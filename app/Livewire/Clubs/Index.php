<?php

namespace App\Livewire\Clubs;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $clubs = \App\Models\Club::with(['disciplines', 'personnes', 'sources', 'lieux'])->paginate(15);
        return view('livewire.clubs.index', compact('clubs'));
    }
}
