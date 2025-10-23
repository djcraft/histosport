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
    public $source_ids = [];
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
        ]);
    }

    public function save()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'siege_id' => 'nullable|exists:lieux,lieu_id',
        ]);

        $club = Club::create([
            'nom' => $this->nom,
            'siege_id' => $this->siege_id,
        ]);

        // Sources (morphToMany)
        if (!empty($this->source_ids)) {
            $club->sources()->sync($this->source_ids);
        }

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
