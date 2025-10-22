<?php

namespace App\Livewire\Personnes;

use Livewire\Component;

class Create extends Component
{
    public function render()
    {
    $allClubs = \App\Models\Club::all();
    $sources = \App\Models\Source::all();
    return view('livewire.personnes.create', compact('allClubs', 'sources'));
    }
}
