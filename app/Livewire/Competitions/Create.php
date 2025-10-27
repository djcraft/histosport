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

        $competition = Competition::create([
            'nom' => $this->nom,
            'date' => $this->date,
            'lieu_id' => $this->lieu_id,
            'organisateur_club_id' => $this->organisateur_club_id,
            'organisateur_personne_id' => $this->organisateur_personne_id,
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
