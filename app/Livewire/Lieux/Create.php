<?php

namespace App\Livewire\Lieux;

use Livewire\Component;

class Create extends Component
{
    public $nom;
    public $adresse;
    public $code_postal;
    public $commune;
    public $departement;
    public $pays;

    public function save()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:20',
            'commune' => 'nullable|string|max:100',
            'departement' => 'nullable|string|max:100',
            'pays' => 'nullable|string|max:100',
        ]);

        \App\Models\Lieu::create([
            'nom' => $this->nom,
            'adresse' => $this->adresse,
            'code_postal' => $this->code_postal,
            'commune' => $this->commune,
            'departement' => $this->departement,
            'pays' => $this->pays,
        ]);

        session()->flash('success', 'Lieu créé avec succès.');
        return redirect()->route('lieux.index');
    }

    public function render()
    {
        return view('livewire.lieux.create');
    }
}
