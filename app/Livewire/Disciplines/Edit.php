<?php

namespace App\Livewire\Disciplines;

use Livewire\Component;

class Edit extends Component
{
    public $nom;
    public $description;
    public $disciplineId;
    public $confirmingDelete = false;

    public function mount($discipline = null)
    {
        if ($discipline) {
            $discipline = \App\Models\Discipline::findOrFail($discipline);
            $this->disciplineId = $discipline->id;
            $this->nom = $discipline->nom;
            $this->description = $discipline->description;
        }
    }

        public function update()
        {
            $this->validate([
                'nom' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $discipline = \App\Models\Discipline::where('nom', $this->nom)->first();
            if (!$discipline) {
                // Si la discipline n'existe pas, on peut lever une erreur ou simplement retourner
                session()->flash('error', 'Discipline non trouvée.');
                return;
            }
            $discipline->nom = $this->nom;
            $discipline->description = $this->description;
            $discipline->save();

            session()->flash('success', 'Discipline modifiée avec succès.');
            return redirect()->route('disciplines.index');
        }

    public function render()
    {
        return view('livewire.disciplines.edit');
    }
}
