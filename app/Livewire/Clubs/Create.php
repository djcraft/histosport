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
            'siege_id' => $this->siege_id,
        ]);

        // Sources (morphToMany)
        $club->sources()->syncWithPivotValues(
            array_map('intval', (array) $this->selectedSources),
            ['entity_type' => 'club']
        );

        // Personnes (many-to-many)
        if (!empty($this->personnes)) {
            $club->personnes()->sync($this->personnes);
        }

        // Disciplines (many-to-many)
        if (!empty($this->disciplines)) {
            $club->disciplines()->sync($this->disciplines);
        }

        session()->flash('success', 'Club créé avec succès.');
        return redirect()->route('clubs.index');
    }
}
