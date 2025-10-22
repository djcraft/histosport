<?php

namespace App\Livewire\Personnes;

use Livewire\Component;

class Edit extends Component
{
    public function render()
    {
    $allClubs = \App\Models\Club::all();
    $sources = \App\Models\Source::all();
    return view('livewire.personnes.edit', compact('allClubs', 'sources'));
    }
}
