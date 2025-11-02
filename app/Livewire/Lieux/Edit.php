<?php

namespace App\Livewire\Lieux;

use Livewire\Component;

class Edit extends Component
{
    public $lieu;
    public $nom;
    public $adresse;
    public $code_postal;
    public $commune;
    public $departement;
    public $pays;

    public function mount($lieu)
    {
    $this->lieu = \App\Models\Lieu::findOrFail($lieu);
    $this->nom = $this->lieu->nom;
    $this->adresse = $this->lieu->adresse;
    $this->code_postal = $this->lieu->code_postal;
    $this->commune = $this->lieu->commune;
    $this->departement = $this->lieu->departement;
    $this->pays = $this->lieu->pays;
    }

    public function update()
    {
        $this->validate([
            'nom' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:20',
            'commune' => 'nullable|string|max:100',
            'departement' => 'nullable|string|max:100',
            'pays' => 'nullable|string|max:100',
        ]);

        $this->lieu->update([
            'nom' => $this->nom,
            'adresse' => $this->adresse,
            'code_postal' => $this->code_postal,
            'commune' => $this->commune,
            'departement' => $this->departement,
            'pays' => $this->pays,
        ]);

        session()->flash('success', 'Lieu mis à jour avec succès.');
        return redirect()->route('lieux.index');
    }

    public function render()
    {
        return view('livewire.lieux.edit');
    }
}
