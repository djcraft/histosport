<?php

namespace App\Livewire\Clubs;

use Livewire\Component;

use App\Models\Club;
use App\Models\Personne;
use App\Models\Discipline;
use App\Models\Lieu;
use App\Models\Source;

class Edit extends Component
{
    public $club;
    public $nom;
    public $nom_origine;
    public $surnoms;
    public $date_fondation;
    public $date_disparition;
    public $date_declaration;
    public $acronyme;
    public $couleurs;
    public $notes;
    public $siege_id;
    public $sources = [];
    public $selectedSources = [];
    public $personnes = [];
    public $disciplines = [];
    public $lieux = [];
    public $selectedPersonnes = [];
    public $selectedDisciplines = [];

    public function mount(Club $club)
    {
        $club->load('sources');
        $this->club = $club;
        $this->nom = $club->nom;
        $this->nom_origine = $club->nom_origine;
        $this->surnoms = $club->surnoms;
        $this->date_fondation = $club->date_fondation;
        $this->date_disparition = $club->date_disparition;
        $this->date_declaration = $club->date_declaration;
        $this->acronyme = $club->acronyme;
        $this->couleurs = $club->couleurs;
        $this->notes = $club->notes;
        $this->siege_id = $club->siege_id;
        $this->sources = Source::all();
        $this->selectedSources = $club->sources->pluck('source_id')->toArray();
        $this->personnes = Personne::all();
        $this->disciplines = Discipline::all();
        $this->lieux = Lieu::all();
        $this->selectedPersonnes = $club->personnes->pluck('personne_id')->toArray();
        $this->selectedDisciplines = $club->disciplines->pluck('discipline_id')->toArray();
    }

    public function render()
    {
        return view('livewire.clubs.edit', [
            'lieux' => $this->lieux,
            'sources' => $this->sources,
            'personnes' => $this->personnes,
            'disciplines' => $this->disciplines,
            'selectedPersonnes' => $this->selectedPersonnes,
            'selectedDisciplines' => $this->selectedDisciplines,
            'selectedSources' => $this->selectedSources,
        ]);
    }

    public function update()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'siege_id' => 'nullable|exists:lieu,lieu_id',
        ]);

        $this->club->update([
            'nom' => $this->nom,
            'nom_origine' => $this->nom_origine,
            'surnoms' => $this->surnoms,
            'date_fondation' => $this->date_fondation,
            'date_disparition' => $this->date_disparition,
            'date_declaration' => $this->date_declaration,
            'acronyme' => $this->acronyme,
            'couleurs' => $this->couleurs,
            'notes' => $this->notes,
            'siege_id' => $this->siege_id,
        ]);

        // Sources (morphToMany)
            $this->club->sources()->syncWithPivotValues(
                array_map('intval', (array) $this->selectedSources),
                ['entity_type' => 'club']
            );
        $this->club->refresh();
        $this->club->load('sources');

        // Personnes (many-to-many)
        $this->club->personnes()->sync($this->selectedPersonnes);

        // Disciplines (many-to-many)
        $this->club->disciplines()->sync($this->selectedDisciplines);

        session()->flash('success', 'Club mis à jour avec succès.');
        return redirect()->route('clubs.index');
    }
}
