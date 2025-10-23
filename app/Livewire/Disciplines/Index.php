<?php

namespace App\Livewire\Disciplines;

use Livewire\Component;

class Index extends Component
{

    public function render()
    {
    $disciplines = \App\Models\Discipline::with(['clubs', 'personnes'])->paginate(15);
        return view('livewire.disciplines.index', compact('disciplines'));
    }
}
