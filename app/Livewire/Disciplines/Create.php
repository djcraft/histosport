<?php

namespace App\Livewire\Disciplines;

use App\Livewire\BaseCrudComponent;
use App\Livewire\Actions\ValidateForm;
use App\Livewire\Actions\Notify;

class Create extends BaseCrudComponent
{
    public $nom;
    public $description;
    protected $rules = [
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

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
