<?php

namespace App\Livewire\Lieux;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
    $lieux = \App\Models\Lieu::with(['clubs'])->paginate(15);
        return view('livewire.lieux.index', compact('lieux'));
    }
}
