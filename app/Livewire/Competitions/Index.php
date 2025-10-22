<?php

namespace App\Livewire\Competitions;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $competitions = \App\Models\Competition::with(['participants', 'sources'])->paginate(15);
        return view('livewire.competitions.index', compact('competitions'));
    }
}
