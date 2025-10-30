<?php

namespace App\Livewire\Competitions;

use Livewire\Component;

use App\Models\Competition;
use App\Models\Discipline;

class Edit extends Component
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
            if ($p->club_id) return 'club_' . $p->club_id;
            if ($p->personne_id) return 'personne_' . $p->personne_id;
            return null;
        })->filter()->toArray();

        // Initialisation des participants clubs/personnes pour le formulaire
        $this->participant_club_ids = collect($competition->participants)->pluck('club_id')->filter()->unique()->values()->toArray();
        $this->participant_personne_ids = collect($competition->participants)->pluck('personne_id')->filter()->unique()->values()->toArray();
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
        $this->validate([
            'nom' => 'required|string|max:255',
            'discipline_ids' => 'array',
            'discipline_ids.*' => 'exists:disciplines,discipline_id',
            'site_ids' => 'nullable|array',
            'site_ids.*' => 'exists:lieu,lieu_id',
            // ... autres règles de validation
        ]);

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
        if (!empty($this->participants)) {
            foreach ($this->participants as $participant) {
                if (str_starts_with($participant, 'club_')) {
                    $clubId = (int)str_replace('club_', '', $participant);
                    \App\Models\CompetitionParticipant::create([
                        'competition_id' => $this->competition->competition_id,
                        'club_id' => $clubId,
                    ]);
                } elseif (str_starts_with($participant, 'personne_')) {
                    $personneId = (int)str_replace('personne_', '', $participant);
                    \App\Models\CompetitionParticipant::create([
                        'competition_id' => $this->competition->competition_id,
                        'personne_id' => $personneId,
                    ]);
                }
            }
        }

        session()->flash('success', 'Compétition modifiée avec succès.');
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
}
