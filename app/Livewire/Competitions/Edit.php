<?php

namespace App\Livewire\Competitions;

use App\Livewire\BaseCrudComponent;
use App\Models\Competition;
use App\Models\Discipline;
use Illuminate\Support\Facades\Log;

class Edit extends BaseCrudComponent
{
    public $competition;
    public $nom;
    public $date;
    public $lieu_id;
    public $site_ids = [];
    public $organisateur_club_id;
    public $organisateur_personne_id;
    public $type;
    public $duree;
    public $niveau;
    public $discipline_ids = [];
    public $sources = [];
    public $participants = [];
    public $showForm = false;
    public $selectedParticipantId = null;
    public $resultatParticipant = '';
    public $participant_club_ids = [];
    public $participant_personne_ids = [];

    protected $listeners = [
        'lieuCreated' => 'onLieuCreated',
        'disciplineCreated' => 'onDisciplineCreated',
        'sourceCreated' => 'onSourceCreated',
    ];

    protected function rules()
    {
        return \App\Rules\CompetitionRules::rules();
    }

    public function mount(Competition $competition)
    {
        $this->competition = $competition;
        $this->nom = $competition->nom;
        $this->date = $competition->date;
        $this->lieu_id = $competition->lieu_id;
        $this->site_ids = $competition->sites->pluck('lieu_id')->toArray();
        $this->organisateur_club_id = $competition->organisateur_club_id;
        $this->organisateur_personne_id = $competition->organisateur_personne_id;
        $this->type = $competition->type;
        $this->duree = $competition->duree;
        $this->niveau = $competition->niveau;
        $this->discipline_ids = $competition->disciplines->pluck('discipline_id')->toArray();
        $this->sources = $competition->sources->pluck('source_id')->toArray();
        $this->participants = collect($competition->participants)->map(function($p) {
            if ($p->club_id) {
                return [
                    'type' => 'club',
                    'club_id' => $p->club_id,
                    'nom' => optional($p->club)->nom,
                    'resultat' => $p->resultat,
                ];
            }
            if ($p->personne_id) {
                return [
                    'type' => 'personne',
                    'personne_id' => $p->personne_id,
                    'nom' => optional($p->personne)->nom,
                    'prenom' => optional($p->personne)->prenom,
                    'resultat' => $p->resultat,
                ];
            }
            return null;
        })->filter()->values()->toArray();

        // Initialisation des participants clubs/personnes pour le formulaire
        // Initialisation uniquement si les propriétés sont vides (évite la réinitialisation après action utilisateur)
        if (empty($this->participant_club_ids)) {
            $allClubIds = collect($competition->participants)->pluck('club_id')->filter()->unique()->values()->toArray();
            $clubIdsAvecResultat = collect($this->participants)
                ->filter(fn($p) => $p['type'] === 'club' && !empty($p['resultat']))
                ->pluck('club_id')
                ->toArray();
            $this->participant_club_ids = array_values(array_diff($allClubIds, $clubIdsAvecResultat));
        }
        if (empty($this->participant_personne_ids)) {
            $allPersonneIds = collect($competition->participants)->pluck('personne_id')->filter()->unique()->values()->toArray();
            $personneIdsAvecResultat = collect($this->participants)
                ->filter(fn($p) => $p['type'] === 'personne' && !empty($p['resultat']))
                ->pluck('personne_id')
                ->toArray();
            $this->participant_personne_ids = array_values(array_diff($allPersonneIds, $personneIdsAvecResultat));
        }
    }

    public function updatedOrganisateurClubId($value)
    {
        // Si on sélectionne un club, on vide le champ personne et le badge
        if (!empty($value)) {
            if (!empty($this->organisateur_personne_id)) {
                $this->organisateur_personne_id = null;
                $this->dispatch('reset-organisateur-personne');
            }
        }
        // Si on tente de sélectionner un autre club, on remplace l’ancien
        if (is_array($value) && count($value) > 1) {
            $this->organisateur_club_id = $value[count($value)-1];
        }
    }

    public function updatedOrganisateurPersonneId($value)
    {
        // Si on sélectionne une personne, on vide le champ club et le badge
        if (!empty($value)) {
            if (!empty($this->organisateur_club_id)) {
                $this->organisateur_club_id = null;
                $this->dispatch('reset-organisateur-club');
            }
        }
        // Si on tente de sélectionner une autre personne, on remplace l’ancienne
        if (is_array($value) && count($value) > 1) {
            $this->organisateur_personne_id = $value[count($value)-1];
        }
    }

    // Ouvre le formulaire d'ajout de résultat club
    public function ouvrirFormulaireClub()
    {
        $this->showForm = 'club';
        $this->selectedParticipantId = null;
        $this->resultatParticipant = '';
    }

    // Ouvre le formulaire d'ajout de résultat personne
    public function ouvrirFormulairePersonne()
    {
        $this->showForm = 'personne';
        $this->selectedParticipantId = null;
        $this->resultatParticipant = '';
    }

    // Ferme le formulaire d'ajout de résultat
    public function fermerFormulaire()
    {
        $this->showForm = false;
        $this->selectedParticipantId = null;
        $this->resultatParticipant = '';
    }

    // Ajoute un résultat club
    public function addResultatClub()
    {
        if ($this->selectedParticipantId) {
            $club = \App\Models\Club::find($this->selectedParticipantId);
            if ($club) {
                // Retirer le club de la barre multi
                $this->participant_club_ids = array_values(array_diff($this->participant_club_ids, [$club->club_id]));
                // Ajouter le participant avec résultat
                $this->participants[] = [
                    'type' => 'club',
                    'club_id' => $club->club_id,
                    'nom' => $club->nom,
                    'resultat' => $this->resultatParticipant,
                ];
            }
            $this->fermerFormulaire();
        } else {
            // Si aucun participant sélectionné, simplement ouvrir le formulaire
            $this->showForm = 'club';
        }
    }

    // Ajoute un résultat personne
    public function addResultatPersonne()
    {
        if ($this->selectedParticipantId) {
            $personne = \App\Models\Personne::find($this->selectedParticipantId);
            if ($personne) {
                // Retirer la personne de la barre multi
                $this->participant_personne_ids = array_values(array_diff($this->participant_personne_ids, [$personne->personne_id]));
                // Ajouter le participant avec résultat
                $this->participants[] = [
                    'type' => 'personne',
                    'personne_id' => $personne->personne_id,
                    'nom' => $personne->nom,
                    'prenom' => $personne->prenom,
                    'resultat' => $this->resultatParticipant,
                ];
            }
            $this->fermerFormulaire();
        } else {
            // Si aucun participant sélectionné, simplement ouvrir le formulaire
            $this->showForm = 'personne';
        }
    }

    public function render()
    {
        $allSources = \App\Models\Source::all();
        $lieux = \App\Models\Lieu::all();
        $clubs = \App\Models\Club::all();
        $personnes = \App\Models\Personne::all();
        $allDisciplines = Discipline::all();
        return view('livewire.competitions.edit', compact('allSources', 'lieux', 'clubs', 'personnes', 'allDisciplines'));
    }

    public function update()
    {
        $this->notify('Update appelé avec : ' . json_encode([
            'nom' => $this->nom,
            'date' => $this->date,
            'lieu_id' => $this->lieu_id,
            'organisateur_club_id' => $this->organisateur_club_id,
            'organisateur_personne_id' => $this->organisateur_personne_id,
            'type' => $this->type,
            'duree' => $this->duree,
            'niveau' => $this->niveau,
        ]), 'info');

        // Empêcher la sélection simultanée d'un club et d'une personne comme organisateur
        if (!empty($this->organisateur_club_id) && !empty($this->organisateur_personne_id)) {
            $this->addError('organisateur_club_id', 'Vous ne pouvez sélectionner qu’un seul organisateur (club ou personne).');
            $this->addError('organisateur_personne_id', 'Vous ne pouvez sélectionner qu’un seul organisateur (club ou personne).');
            return;
        }

        // Détection automatique de la précision de la date
        $datePrecision = null;
        if (preg_match('/^\d{4}$/', $this->date)) {
            $datePrecision = 'year';
        } elseif (preg_match('/^\d{4}-\d{2}$/', $this->date)) {
            $datePrecision = 'month';
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date)) {
            $datePrecision = 'day';
        }

        // Correction : lieu_id doit être un entier ou null, jamais un tableau
        $lieu_id = is_array($this->lieu_id) ? (count($this->lieu_id) ? $this->lieu_id[0] : null) : $this->lieu_id;
        // Correction universelle pour organisateur_club_id
        if (is_array($this->organisateur_club_id)) {
            $organisateur_club_id = count($this->organisateur_club_id) ? $this->organisateur_club_id[0] : null;
        } elseif (is_numeric($this->organisateur_club_id)) {
            $organisateur_club_id = intval($this->organisateur_club_id);
        } else {
            $organisateur_club_id = $this->organisateur_club_id;
        }
        // Correction universelle pour organisateur_personne_id
        if (is_array($this->organisateur_personne_id)) {
            $organisateur_personne_id = count($this->organisateur_personne_id) ? $this->organisateur_personne_id[0] : null;
        } elseif (is_numeric($this->organisateur_personne_id)) {
            $organisateur_personne_id = intval($this->organisateur_personne_id);
        } else {
            $organisateur_personne_id = $this->organisateur_personne_id;
        }

        $this->organisateur_club_id = $organisateur_club_id;
        $this->organisateur_personne_id = $organisateur_personne_id;

            
        $form = [
            'nom' => $this->nom,
            'date' => $this->date,
            'lieu_id' => $this->lieu_id,
            'organisateur_club_id' => $organisateur_club_id,
            'organisateur_personne_id' => $organisateur_personne_id,
            'type' => $this->type,
            'duree' => $this->duree,
            'niveau' => $this->niveau,
        ];

        $validated = \App\Livewire\Actions\ValidateForm::run($form, $this->rules());

        $this->competition->update([
            'nom' => $this->nom,
            'date' => $this->date,
            'date_precision' => $datePrecision,
            'lieu_id' => $lieu_id,
            'organisateur_club_id' => $organisateur_club_id !== '' ? $organisateur_club_id : null,
            'organisateur_personne_id' => $organisateur_personne_id !== '' ? $this->organisateur_personne_id : null,
            'type' => $this->type,
            'duree' => $this->duree,
            'niveau' => $this->niveau,
        ]);


        // Gestion des disciplines (relation n-n) via modèle pivot pour historisation
        $competitionId = $this->competition->competition_id;
        \App\Models\CompetitionDiscipline::where('competition_id', $competitionId)->delete();
        if (!empty($this->discipline_ids)) {
            foreach ($this->discipline_ids as $disciplineId) {
                \App\Models\CompetitionDiscipline::create([
                    'competition_id' => $competitionId,
                    'discipline_id' => $disciplineId,
                ]);
            }
        }

        // Gestion des sites (lieux multiples)
        $this->competition->sites()->sync($this->site_ids);

        // Gestion des sources (ajout du champ entity_type, exclusion des valeurs nulles ou 0)
        $validSources = array_filter(array_map('intval', (array) $this->sources), function($id) {
            return $id > 0;
        });
        $this->competition->sources()->syncWithPivotValues(
            $validSources,
            ['entity_type' => 'competition']
        );

        // Gestion des participants
        $this->competition->participants()->delete();
        // 1. Clubs sélectionnés dans la barre multi (sans résultat)
        foreach ((array)$this->participant_club_ids as $clubId) {
            $existe = false;
            foreach ($this->participants as $p) {
                if ($p['type'] === 'club' && $p['club_id'] == $clubId && !empty($p['resultat'])) {
                    $existe = true;
                    break;
                }
            }
            if (!$existe) {
                \App\Models\CompetitionParticipant::create([
                    'competition_id' => $this->competition->competition_id,
                    'club_id' => $clubId,
                    'resultat' => null,
                ]);
            }
        }
        // 2. Personnes sélectionnées dans la barre multi (sans résultat)
        foreach ((array)$this->participant_personne_ids as $personneId) {
            $existe = false;
            foreach ($this->participants as $p) {
                if ($p['type'] === 'personne' && $p['personne_id'] == $personneId && !empty($p['resultat'])) {
                    $existe = true;
                    break;
                }
            }
            if (!$existe) {
                \App\Models\CompetitionParticipant::create([
                    'competition_id' => $this->competition->competition_id,
                    'personne_id' => $personneId,
                    'resultat' => null,
                ]);
            }
        }
        // 3. Participants avec résultat (clubs et personnes)
        foreach ($this->participants as $p) {
            if ($p['type'] === 'club') {
                // Supprimer le participant sans résultat s'il existe
                \App\Models\CompetitionParticipant::where([
                    ['competition_id', '=', $this->competition->competition_id],
                    ['club_id', '=', $p['club_id']],
                    ['resultat', '=', null],
                ])->delete();
                \App\Models\CompetitionParticipant::create([
                    'competition_id' => $this->competition->competition_id,
                    'club_id' => $p['club_id'],
                    'resultat' => $p['resultat'],
                ]);
            } elseif ($p['type'] === 'personne') {
                \App\Models\CompetitionParticipant::where([
                    ['competition_id', '=', $this->competition->competition_id],
                    ['personne_id', '=', $p['personne_id']],
                    ['resultat', '=', null],
                ])->delete();
                \App\Models\CompetitionParticipant::create([
                    'competition_id' => $this->competition->competition_id,
                    'personne_id' => $p['personne_id'],
                    'resultat' => $p['resultat'],
                ]);
            }
        }
        
        // Redirection vers l'index après mise à jour
        return redirect()->route('competitions.index');
    }
}
