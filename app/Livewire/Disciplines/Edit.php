<?php

namespace App\Livewire\Disciplines;

use App\Livewire\BaseCrudComponent;
use App\Livewire\Actions\ValidateForm;
use App\Livewire\Actions\Notify;

class Edit extends BaseCrudComponent
{
    public $nom;
    public $description;
    public $discipline;
    public $confirmingDelete = false;
    protected function rules()
    {
        return \App\Rules\DisciplineRules::rules();
    }

    public function mount()
    {
        if ($this->discipline) {
            $discipline = \App\Models\Discipline::findOrFail($this->discipline);
            $this->nom = $discipline->nom;
            $this->description = $discipline->description;
        }
    }

    public function update()
    {
        $form = [
            'nom' => $this->nom,
            'description' => $this->description,
        ];
        $validated = ValidateForm::run($form, $this->rules());
        $discipline = \App\Models\Discipline::find($this->discipline);
        if (!$discipline) {
            Notify::run('Discipline non trouvée.', 'error');
            return;
        }
        $discipline->update($validated);
        Notify::run('Discipline modifiée avec succès.');
        return redirect()->route('disciplines.index');
    }

    public function render()
    {
        return view('livewire.disciplines.edit');
    }
}
