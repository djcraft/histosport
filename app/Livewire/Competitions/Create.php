<?php
namespace App\Livewire\Competitions;

use App\Livewire\BaseCrudComponent;

use App\Models\Competition;
use App\Models\Discipline;

class Create extends BaseCrudComponent
{
    // Suppression d’un participant (avec ou sans résultat)
    public function supprimerParticipant($index)
    {
        if (isset($this->participants[$index])) {
            array_splice($this->participants, $index, 1);
        }
    }
    // Règles de validation Livewire pour le formulaire
    protected $rules = [
        'nom' => 'required|string|max:255',
        'discipline_ids' => 'nullable|array',
        'discipline_ids.*' => 'exists:disciplines,discipline_id',
        'site_ids' => 'nullable|array',
        'site_ids.*' => 'exists:lieu,lieu_id',
        'participant_club_ids' => 'nullable|array',
        'participant_club_ids.*' => 'exists:clubs,club_id',
        'participant_personne_ids' => 'nullable|array',
        'participant_personne_ids.*' => 'exists:personnes,personne_id',
    ];
    // Multi sélection pour participants sans résultat
    // (doublon supprimé)

    // La liste des participants (sans résultat) est générée dynamiquement à partir des IDs sélectionnés
    public function getParticipantsProperty()
    {
        $clubs = \App\Models\Club::whereIn('club_id', (array)$this->participant_club_ids)->get();
        $personnes = \App\Models\Personne::whereIn('personne_id', (array)$this->participant_personne_ids)->get();
        $participants = [];
        foreach ($clubs as $club) {
            $participants[] = [
                'type' => 'club',
                'club_id' => $club->club_id,
                'nom' => $club->nom,
            ];
        }
        foreach ($personnes as $personne) {
            $participants[] = [
                'type' => 'personne',
                'personne_id' => $personne->personne_id,
                'nom' => $personne->nom,
                'prenom' => $personne->prenom,
            ];
        }
        // Ajout des participants avec résultat (issus du workflow formulaire)
        foreach ($this->participants as $p) {
            if (!empty($p['resultat'])) {
                $participants[] = $p;
            }
        }
        return $participants;
    }
    // (doublon supprimé)
    // $showForm géré pour le formulaire résultat participant
    public $selectedClubId = null;
    public $resultatClub = '';
    public $selectedPersonneId = null;
    public $resultatPersonne = '';

    public function toggleForm($type)
    {
        $this->showForm = $this->showForm === $type ? null : $type;
        $this->selectedClubId = null;
        $this->resultatClub = '';
        $this->selectedPersonneId = null;
        $this->resultatPersonne = '';
    }

    public function addParticipantClub()
    {
        if ($this->selectedClubId) {
            $club = \App\Models\Club::where('club_id', $this->selectedClubId)->first();
            if ($club) {
                $this->participants[] = [
                    'type' => 'club',
                    'club_id' => $club->club_id,
                    'nom' => $club->nom,
                    'resultat' => $this->resultatClub,
                ];
                $this->participant_club_ids[] = $club->club_id;
            }
        }
        $this->showForm = null;
        $this->selectedClubId = null;
        $this->resultatClub = '';
    }

    public function addParticipantPersonne()
    {
        if ($this->selectedPersonneId) {
            $personne = \App\Models\Personne::where('personne_id', $this->selectedPersonneId)->first();
            if ($personne) {
                $this->participants[] = [
                    'type' => 'personne',
                    'personne_id' => $personne->personne_id,
                    'nom' => $personne->nom,
                    'prenom' => $personne->prenom,
                    'resultat' => $this->resultatPersonne,
                ];
                $this->participant_personne_ids[] = $personne->personne_id;
            }
        }
        $this->showForm = null;
        $this->selectedPersonneId = null;
        $this->resultatPersonne = '';
    }
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
    public $participant_club_ids = [];
    public $participant_personne_ids = [];
    public $selected_source_id = [];
    public $resetKeyClub = 0;
    public $resetKeyPersonne = 0;
    public $resetKeyLieu = 0;
    // Ajout pour le formulaire résultat participant
    public $showForm = false;
    public $typeParticipant = 'club';
    public $selectedParticipantId = null;
    public $resultatParticipant = '';


    protected $listeners = [
        'reset-organisateur-club' => 'forceResetOrganisateurClub',
        'reset-organisateur-personne' => 'forceResetOrganisateurPersonne',
        'lieuCreated' => 'onLieuCreated',
        'disciplineCreated' => 'onDisciplineCreated',
        'sourceCreated' => 'onSourceCreated',
    ];

    public function onLieuCreated($id)
    {
    $this->lieu_id = $id;
    $this->resetKeyLieu++;
    }

    public function onDisciplineCreated($id)
    {
    $this->discipline_ids = array_filter((array)$this->discipline_ids, fn($v) => !is_null($v) && $v !== '');
    $this->discipline_ids[] = $id;
    $this->dispatch('$refresh');
    }

    public function onSourceCreated($id)
    {
    $this->sources[] = $id;
    }

    public function forceResetOrganisateurClub()
    {
        $this->organisateur_club_id = null;
        $this->resetKeyClub++;
        $this->dispatch('reset-organisateur-club');
    }

    public function forceResetOrganisateurPersonne()
    {
        $this->organisateur_personne_id = null;
        $this->resetKeyPersonne++;
        $this->dispatch('reset-organisateur-personne');
    }


    // Contrôle côté vue : un seul organisateur
    public function updatedOrganisateurClubId($value)
    {
        // Si on sélectionne un club, on vide le champ personne et le badge
        if ($value) {
            if ($this->organisateur_personne_id !== null && $this->organisateur_personne_id !== '' && $this->organisateur_personne_id != 0) {
                $this->organisateur_personne_id = null;
                $this->resetKeyPersonne++;
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
        if ($value) {
            if ($this->organisateur_club_id !== null && $this->organisateur_club_id !== '' && $this->organisateur_club_id != 0) {
                $this->organisateur_club_id = null;
                $this->resetKeyClub++;
                $this->dispatch('reset-organisateur-club');
            }
        }
        // Si on tente de sélectionner une autre personne, on remplace l’ancienne
        if (is_array($value) && count($value) > 1) {
            $this->organisateur_personne_id = $value[count($value)-1];
        }
    }

    public function render()
    {
        $allSources = \App\Models\Source::all();
        $lieux = \App\Models\Lieu::all();
        $clubs = \App\Models\Club::all();
        $personnes = \App\Models\Personne::all();
        $allDisciplines = Discipline::all();
        // Correction : discipline_ids doit toujours être un tableau
        $this->discipline_ids = is_array($this->discipline_ids) ? $this->discipline_ids : collect($this->discipline_ids)->toArray();
        $this->discipline_ids = array_filter((array)$this->discipline_ids, fn($v) => !is_null($v) && $v !== '');
        $ids = $this->discipline_ids;
        $selectedDisciplines = [];
        if (!empty($ids)) {
            $selectedDisciplines = \App\Models\Discipline::whereIn('discipline_id', $ids)->get();
        }
        return view('livewire.competitions.create', compact('allSources', 'lieux', 'clubs', 'personnes', 'allDisciplines', 'selectedDisciplines'));
    }

    public function save()
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

        // Correction : conversion en scalaires si tableau
        $lieu_id = is_array($this->lieu_id) ? (count($this->lieu_id) ? $this->lieu_id[count($this->lieu_id)-1] : null) : $this->lieu_id;
        $organisateur_club_id = is_array($this->organisateur_club_id) ? (count($this->organisateur_club_id) ? $this->organisateur_club_id[count($this->organisateur_club_id)-1] : null) : $this->organisateur_club_id;
        $organisateur_personne_id = is_array($this->organisateur_personne_id) ? (count($this->organisateur_personne_id) ? $this->organisateur_personne_id[count($this->organisateur_personne_id)-1] : null) : $this->organisateur_personne_id;

        // Les participants sont déjà dans $this->participants sous forme de tableau associatif

        $competition = Competition::create([
            'nom' => $this->nom,
            'date' => $this->date,
            'date_precision' => $datePrecision,
            'lieu_id' => $lieu_id,
            'organisateur_club_id' => $organisateur_club_id,
            'organisateur_personne_id' => $organisateur_personne_id,
            'type' => $this->type,
            'duree' => $this->duree,
            'niveau' => $this->niveau,
        ]);

        // Gestion des disciplines (relation n-n)
        if (!empty($this->discipline_ids)) {
            $competition->disciplines()->sync($this->discipline_ids);
        }

        // Gestion des sites (lieux multiples)
        if (!empty($this->site_ids)) {
            $competition->sites()->sync($this->site_ids);
        }

        // Gestion des sources (relation morphToMany)
        if (!empty($this->sources)) {
            foreach ($this->sources as $sourceId) {
                $competition->sources()->attach($sourceId, ['entity_type' => 'competition']);
            }
        }

        // Gestion des participants (clubs et personnes) avec ou sans résultat
        // 1. Clubs sélectionnés dans la barre multi
        foreach ((array)$this->participant_club_ids as $clubId) {
            \App\Models\CompetitionParticipant::create([
                'competition_id' => $competition->competition_id,
                'club_id' => $clubId,
                'resultat' => null,
            ]);
        }
        // 2. Personnes sélectionnées dans la barre multi
        foreach ((array)$this->participant_personne_ids as $personneId) {
            \App\Models\CompetitionParticipant::create([
                'competition_id' => $competition->competition_id,
                'personne_id' => $personneId,
                'resultat' => null,
            ]);
        }
        // 3. Participants ajoutés via le formulaire résultat
        if (!empty($this->participants)) {
            foreach ($this->participants as $participant) {
                if (!empty($participant['resultat'])) {
                    if ($participant['type'] === 'club') {
                        \App\Models\CompetitionParticipant::create([
                            'competition_id' => $competition->competition_id,
                            'club_id' => $participant['club_id'],
                            'resultat' => $participant['resultat'],
                        ]);
                    } elseif ($participant['type'] === 'personne') {
                        \App\Models\CompetitionParticipant::create([
                            'competition_id' => $competition->competition_id,
                            'personne_id' => $participant['personne_id'],
                            'resultat' => $participant['resultat'],
                        ]);
                    }
                }
            }
        }

    $this->notify('Compétition créée avec succès.');
    return redirect()->route('competitions.index');
    }

    public function addResultat()
    {
        if ($this->typeParticipant === 'club' && $this->selectedParticipantId) {
            $club = \App\Models\Club::where('club_id', $this->selectedParticipantId)->first();
            if ($club) {
                $this->participants[] = [
                    'type' => 'club',
                    'club_id' => $club->club_id,
                    'nom' => $club->nom,
                    'resultat' => $this->resultatParticipant,
                ];
            }
        } elseif ($this->typeParticipant === 'personne' && $this->selectedParticipantId) {
            $personne = \App\Models\Personne::where('personne_id', $this->selectedParticipantId)->first();
            if ($personne) {
                $this->participants[] = [
                    'type' => 'personne',
                    'personne_id' => $personne->personne_id,
                    'nom' => $personne->nom,
                    'prenom' => $personne->prenom,
                    'resultat' => $this->resultatParticipant,
                ];
            }
        }
        $this->showForm = false;
        $this->typeParticipant = 'club';
        $this->selectedParticipantId = null;
        $this->resultatParticipant = '';
    }

    public function ouvrirFormulaireClub()
    {
        $this->showForm = 'club';
        $this->selectedParticipantId = null;
        $this->resultatParticipant = '';
    }

    public function ouvrirFormulairePersonne()
    {
        $this->showForm = 'personne';
        $this->selectedParticipantId = null;
        $this->resultatParticipant = '';
    }

    public function addResultatClub()
    {
        if ($this->selectedParticipantId) {
            $club = \App\Models\Club::where('club_id', $this->selectedParticipantId)->first();
            if ($club) {
                $this->participants[] = [
                    'type' => 'club',
                    'club_id' => $club->club_id,
                    'nom' => $club->nom,
                    'resultat' => $this->resultatParticipant,
                ];
            }
        }
        $this->fermerFormulaire();
    }

    public function addResultatPersonne()
    {
        if ($this->selectedParticipantId) {
            $personne = \App\Models\Personne::where('personne_id', $this->selectedParticipantId)->first();
            if ($personne) {
                $this->participants[] = [
                    'type' => 'personne',
                    'personne_id' => $personne->personne_id,
                    'nom' => $personne->nom,
                    'prenom' => $personne->prenom,
                    'resultat' => $this->resultatParticipant,
                ];
            }
        }
        $this->fermerFormulaire();
    }

    public function fermerFormulaire()
    {
        $this->showForm = false;
        $this->selectedParticipantId = null;
        $this->resultatParticipant = '';
    }
    public $typeRecherche = 'club';
    public $selectedRechercheId = null;

    public function associerParticipant()
    {
        if ($this->typeRecherche === 'club' && $this->selectedRechercheId) {
            $club = \App\Models\Club::where('club_id', $this->selectedRechercheId)->first();
            if ($club) {
                $this->participants[] = [
                    'type' => 'club',
                    'club_id' => $club->club_id,
                    'nom' => $club->nom,
                ];
            }
        } elseif ($this->typeRecherche === 'personne' && $this->selectedRechercheId) {
            $personne = \App\Models\Personne::where('personne_id', $this->selectedRechercheId)->first();
            if ($personne) {
                $this->participants[] = [
                    'type' => 'personne',
                    'personne_id' => $personne->personne_id,
                    'nom' => $personne->nom,
                    'prenom' => $personne->prenom,
                ];
            }
        }
        $this->selectedRechercheId = null;
    }
}
