<?php

namespace App\Livewire\Lieux;

use App\Livewire\BaseCrudComponent;
use App\Livewire\Actions\Notify;

class Edit extends BaseCrudComponent
{
    public $lieu;
    public $nom;
    public $adresse;
    public $code_postal;
    public $commune;
    public $departement;
    public $pays;
    protected function rules()
    {
        return \App\Rules\LieuRules::rules();
    }

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
        $this->validate($this->rules);
        $this->lieu->update([
            'nom' => $this->nom,
            'adresse' => $this->adresse,
            'code_postal' => $this->code_postal,
            'commune' => $this->commune,
            'departement' => $this->departement,
            'pays' => $this->pays,
        ]);
        Notify::run('Lieu mis à jour avec succès.');
        return redirect()->route('lieux.index');
    }

    public function render()
    {
        return view('livewire.lieux.edit');
    }
}
