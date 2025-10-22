<?php

namespace App\Livewire\Disciplines;

use Livewire\Component;

class Show extends Component
{
    public $discipline;

    public function mount($discipline = null)
    {
        if ($discipline) {
            $this->discipline = \App\Models\Discipline::with(['historisations'])->findOrFail($discipline);
        } elseif (request()->route('discipline')) {
            $this->discipline = \App\Models\Discipline::with(['historisations'])->findOrFail(request()->route('discipline'));
        }
    }


    public function render()
    {
        $discipline = $this->discipline;
        return view('livewire.disciplines.show', compact('discipline'));
    }
}
