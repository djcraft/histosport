<?php

namespace App\Livewire\Clubs;

use Livewire\Component;

class Create extends Component
{
    public function render()
    {
    $lieux = \App\Models\Lieu::all();
    $sources = \App\Models\Source::all();
    return view('livewire.clubs.create', compact('lieux', 'sources'));
    }
}
