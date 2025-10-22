<?php

namespace App\Livewire\Disciplines;

use Livewire\Component;

class Create extends Component
{
    public $nom;
    public $description;

    public function save()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        \App\Models\Discipline::create([
            'nom' => $this->nom,
            'description' => $this->description,
        ]);
        session()->flash('success', 'Discipline créée avec succès');
        return redirect()->route('disciplines.index');
    }

    public function render()
    {
        return view('livewire.disciplines.create');
    }
}
