<?php

namespace App\Livewire\Competitions;

use Livewire\Component;

use App\Models\Competition;
use App\Models\Discipline;

class Create extends Component

{
    public $nom;
    public $date;
    public $lieu_id;
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

    protected $listeners = [
        'reset-organisateur-club' => 'forceResetOrganisateurClub',
        'reset-organisateur-personne' => 'forceResetOrganisateurPersonne',
    ];

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
        // Pour le formulaire, on propose la liste des clubs et personnes comme participants potentiels
        return view('livewire.competitions.create', compact('allSources', 'lieux', 'clubs', 'personnes', 'allDisciplines'));
    }

    public function save()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'discipline_ids' => 'nullable|array',
            'discipline_ids.*' => 'exists:disciplines,discipline_id',
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

        // Correction : conversion en scalaires si tableau
        $lieu_id = is_array($this->lieu_id) ? (count($this->lieu_id) ? $this->lieu_id[count($this->lieu_id)-1] : null) : $this->lieu_id;
        $organisateur_club_id = is_array($this->organisateur_club_id) ? (count($this->organisateur_club_id) ? $this->organisateur_club_id[count($this->organisateur_club_id)-1] : null) : $this->organisateur_club_id;
        $organisateur_personne_id = is_array($this->organisateur_personne_id) ? (count($this->organisateur_personne_id) ? $this->organisateur_personne_id[count($this->organisateur_personne_id)-1] : null) : $this->organisateur_personne_id;

        // Synchronisation des participants et sources sélectionnés
        $this->participants = [];
        foreach ((array)$this->participant_club_ids as $clubId) {
            if ($clubId) $this->participants[] = 'club_' . $clubId;
        }
        foreach ((array)$this->participant_personne_ids as $personneId) {
            if ($personneId) $this->participants[] = 'personne_' . $personneId;
        }
        $this->sources = (array)$this->selected_source_id;

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

        // Gestion des sources (relation morphToMany)
        if (!empty($this->sources)) {
            foreach ($this->sources as $sourceId) {
                $competition->sources()->attach($sourceId, ['entity_type' => 'competition']);
            }
        }

        // Gestion des participants (clubs et personnes)
        if (!empty($this->participants)) {
            foreach ($this->participants as $participant) {
                if (str_starts_with($participant, 'club_')) {
                    $clubId = (int)str_replace('club_', '', $participant);
                    \App\Models\CompetitionParticipant::create([
                        'competition_id' => $competition->competition_id,
                        'club_id' => $clubId,
                    ]);
                } elseif (str_starts_with($participant, 'personne_')) {
                    $personneId = (int)str_replace('personne_', '', $participant);
                    \App\Models\CompetitionParticipant::create([
                        'competition_id' => $competition->competition_id,
                        'personne_id' => $personneId,
                    ]);
                }
            }
        }

        session()->flash('success', 'Compétition créée avec succès.');
        return redirect()->route('competitions.index');
    }
}
