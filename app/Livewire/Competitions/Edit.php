<?php
namespace App\Livewire\Competitions;

use App\Livewire\BaseCrudComponent;

use App\Models\Competition;
use App\Models\Discipline;

class Edit extends BaseCrudComponent
{
    protected function rules()
    {
        return \App\Rules\CompetitionRules::rules();
    }
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

    // Contrôle côté vue : un seul organisateur
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
            $this->participant_club_ids = collect($competition->participants)->pluck('club_id')->filter()->unique()->values()->toArray();
        }
        if (empty($this->participant_personne_ids)) {
            $this->participant_personne_ids = collect($competition->participants)->pluck('personne_id')->filter()->unique()->values()->toArray();
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
        $this->validate($this->rules);

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
        $this->competition->update([
            'nom' => $this->nom,
            'date' => $this->date,
            'date_precision' => $datePrecision,
            'lieu_id' => $lieu_id,
            'organisateur_club_id' => $this->organisateur_club_id !== '' ? $this->organisateur_club_id : null,
            'organisateur_personne_id' => $this->organisateur_personne_id !== '' ? $this->organisateur_personne_id : null,
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
            // Vérifier que le club n'est pas déjà dans $participants avec un résultat
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
        // 3. Participants ajoutés via le formulaire résultat
        if (!empty($this->participants)) {
            foreach ($this->participants as $participant) {
                if (!empty($participant['resultat'])) {
                    if ($participant['type'] === 'club') {
                        \App\Models\CompetitionParticipant::create([
                            'competition_id' => $this->competition->competition_id,
                            'club_id' => $participant['club_id'],
                            'resultat' => $participant['resultat'],
                        ]);
                    } elseif ($participant['type'] === 'personne') {
                        \App\Models\CompetitionParticipant::create([
                            'competition_id' => $this->competition->competition_id,
                            'personne_id' => $participant['personne_id'],
                            'resultat' => $participant['resultat'],
                        ]);
                    }
                }
            }
        }

    $this->notify('Compétition modifiée avec succès.');
    return redirect()->route('competitions.index');
    }

    public function onLieuCreated($id)
    {
        $this->lieu_id = $id;
    }

    public function onDisciplineCreated($id)
    {
        $this->discipline_ids[] = $id;
    }

    public function onSourceCreated($id)
    {
        $this->sources[] = $id;
    }
    public $editIndex = null;
    public $editResultat = '';

        // Supprime un club sans résultat (pour suppression persistante via multi-select)
        public function supprimerClubSansResultat($clubId)
        {
            $this->participant_club_ids = array_values(array_diff($this->participant_club_ids, [$clubId]));
            // Supprimer le participant du tableau $participants dans tous les cas (avec ou sans résultat)
            $this->participants = array_values(array_filter($this->participants, function($p) use ($clubId) {
                return !($p['type'] === 'club' && $p['club_id'] == $clubId);
            }));
        }

        // Supprime une personne sans résultat (pour suppression persistante via multi-select)
        public function supprimerPersonneSansResultat($personneId)
        {
            $this->participant_personne_ids = array_values(array_diff($this->participant_personne_ids, [$personneId]));
            // Supprimer le participant du tableau $participants dans tous les cas (avec ou sans résultat)
            $this->participants = array_values(array_filter($this->participants, function($p) use ($personneId) {
                return !($p['type'] === 'personne' && $p['personne_id'] == $personneId);
            }));
        }

    // Lance la modification d'un participant (résultat)
    public function modifierParticipant($index)
    {
        $participant = $this->participants[$index] ?? null;
        if ($participant) {
            $this->editIndex = $index;
            // Pré-remplir le formulaire avec les données du participant
            if ($participant['type'] === 'club') {
                $this->showForm = 'club';
                $this->selectedParticipantId = $participant['club_id'] ?? null;
            } elseif ($participant['type'] === 'personne') {
                $this->showForm = 'personne';
                $this->selectedParticipantId = $participant['personne_id'] ?? null;
            }
            $this->resultatParticipant = $participant['resultat'] ?? '';
        }
    }

    // Valide la modification du résultat
    public function validerModificationParticipant($index)
    {
        if (isset($this->participants[$index])) {
            // Mettre à jour l'entité et le résultat avec les valeurs du formulaire
            if ($this->showForm === 'club') {
                $club = \App\Models\Club::find($this->selectedParticipantId);
                if ($club) {
                    $this->participants[$index] = [
                        'type' => 'club',
                        'club_id' => $club->club_id,
                        'nom' => $club->nom,
                        'resultat' => $this->resultatParticipant,
                    ];
                }
            } elseif ($this->showForm === 'personne') {
                $personne = \App\Models\Personne::find($this->selectedParticipantId);
                if ($personne) {
                    $this->participants[$index] = [
                        'type' => 'personne',
                        'personne_id' => $personne->personne_id,
                        'nom' => $personne->nom,
                        'prenom' => $personne->prenom,
                        'resultat' => $this->resultatParticipant,
                    ];
                }
            }
            // Si le résultat devient null, supprimer simplement le participant
            if (is_null($this->resultatParticipant) || $this->resultatParticipant === '') {
                array_splice($this->participants, $index, 1);
            }
        }
        $this->editIndex = null;
        $this->resultatParticipant = '';
        $this->selectedParticipantId = null;
        $this->showForm = false;
    }

    // Annule la modification
    public function annulerModificationParticipant()
    {
    $this->editIndex = null;
    $this->editResultat = '';
    $this->showForm = false;
    $this->selectedParticipantId = null;
    $this->resultatParticipant = '';
    }

    // Supprime un participant par son index
    public function supprimerParticipant($index)
    {
        if (isset($this->participants[$index])) {
            array_splice($this->participants, $index, 1);
        }
    }
}
