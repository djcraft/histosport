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
    public $organisateur_club_id;
    public $organisateur_personne_id;
    public $type;
    public $duree;
    public $niveau;
    public $discipline_ids = [];
    public $sources = [];
    public $participants = [];

    public function mount(Competition $competition)
    {
        $this->competition = $competition;
        $this->nom = $competition->nom;
        $this->date = $competition->date;
        $this->lieu_id = $competition->lieu_id;
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
            // ... autres règles de validation
        ]);

        // Empêcher la sélection simultanée d'un club et d'une personne comme organisateur
        if (!empty($this->organisateur_club_id) && !empty($this->organisateur_personne_id)) {
            $this->addError('organisateur_club_id', 'Vous ne pouvez sélectionner qu’un seul organisateur (club ou personne).');
            $this->addError('organisateur_personne_id', 'Vous ne pouvez sélectionner qu’un seul organisateur (club ou personne).');
            return;
        }

        $this->competition->update([
            'nom' => $this->nom,
            'date' => $this->date,
            'lieu_id' => $this->lieu_id,
            'organisateur_club_id' => $this->organisateur_club_id !== '' ? $this->organisateur_club_id : null,
            'organisateur_personne_id' => $this->organisateur_personne_id !== '' ? $this->organisateur_personne_id : null,
            'type' => $this->type,
            'duree' => $this->duree,
            'niveau' => $this->niveau,
        ]);

        // Gestion des disciplines (relation n-n)
        if (!empty($this->discipline_ids)) {
            $this->competition->disciplines()->sync($this->discipline_ids);
        } else {
            $this->competition->disciplines()->detach();
        }

        // Gestion des sources
        $this->competition->sources()->sync($this->sources);

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
}
