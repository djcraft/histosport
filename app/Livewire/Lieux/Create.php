<?php

namespace App\Livewire\Lieux;

use App\Livewire\BaseCrudComponent;
use App\Livewire\Actions\Notify;

class Create extends BaseCrudComponent
{
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

    public function save()
    {
        $form = [
            'nom' => $this->nom,
            'adresse' => $this->adresse,
            'code_postal' => $this->code_postal,
            'commune' => $this->commune,
            'departement' => $this->departement,
            'pays' => $this->pays,
        ];
        $validated = \App\Livewire\Actions\ValidateForm::run($form, $this->rules());
        \App\Models\Lieu::create($validated);
        Notify::run('Lieu créé avec succès.');
        return redirect()->route('lieux.index');
    }

    public function render()
    {
        return view('livewire.lieux.create');
    }
}
