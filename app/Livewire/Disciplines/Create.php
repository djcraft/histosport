<?php

namespace App\Livewire\Disciplines;

use App\Livewire\BaseCrudComponent;
use App\Livewire\Actions\ValidateForm;
use App\Livewire\Actions\Notify;

class Create extends BaseCrudComponent
{
    public $nom;
    public $description;
    protected function rules()
    {
        return \App\Rules\DisciplineRules::rules();
    }

    public function save()
    {
        $this->form = [
            'nom' => $this->nom,
            'description' => $this->description,
        ];
        $validated = ValidateForm::run($this->form, $this->rules);
        \App\Models\Discipline::create($validated);
        Notify::run('Discipline créée avec succès');
        return redirect()->route('disciplines.index');
    }

    public function render()
    {
        return view('livewire.disciplines.create');
    }
}
