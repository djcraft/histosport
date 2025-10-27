<?php

namespace App\Livewire\Clubs;

use Livewire\Component;
use App\Models\Club;
use App\Models\Personne;
use App\Models\Discipline;
use App\Models\Lieu;
use App\Models\Source;

class Create extends Component
{
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
    public $selectedSources = [];
    public $lieux = [];
    public $sources = [];
    public $personnes = [];
    public $disciplines = [];
    public $selectedPersonnes = [];
    public $selectedDisciplines = [];

    public function mount()
    {
        $this->lieux = Lieu::all();
    $this->sources = Source::all();
        $this->personnes = Personne::all();
        $this->disciplines = Discipline::all();
    }

    public function render()
    {
        return view('livewire.clubs.create', [
            'lieux' => $this->lieux,
            'sources' => $this->sources,
            'personnes' => $this->personnes,
            'disciplines' => $this->disciplines,
            'selectedSources' => $this->selectedSources,
        ]);
    }

    public function save()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'siege_id' => 'nullable|exists:lieu,lieu_id',
        ]);

        $club = Club::create([
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
        $club->sources()->syncWithPivotValues(
            array_map('intval', (array) $this->selectedSources),
            ['entity_type' => 'club']
        );

        // Personnes (many-to-many)
        if (!empty($this->selectedPersonnes)) {
            $club->personnes()->sync($this->selectedPersonnes);
        }

        // Disciplines (many-to-many)
        if (!empty($this->selectedDisciplines)) {
            $club->disciplines()->sync($this->selectedDisciplines);
        }

        session()->flash('success', 'Club créé avec succès.');
        return redirect()->route('clubs.index');
    }
}
