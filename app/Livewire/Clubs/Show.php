<?php

namespace App\Livewire\Clubs;

use Livewire\Component;

class Show extends Component
{
    public function render()
    {
        $club = $this->club ?? null;
        if (!$club && request()->route('club')) {
            $club = \App\Models\Club::with(['disciplines', 'personnes', 'sources', 'siege'])->findOrFail(request()->route('club'));
        }
        return view('livewire.clubs.show', compact('club'));
    }
}
