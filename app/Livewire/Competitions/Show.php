<?php

namespace App\Livewire\Competitions;

use Livewire\Component;

class Show extends Component
{
    public function render()
    {
        $competition = $this->competition ?? null;
        if (!$competition && request()->route('competition')) {
            $competition = \App\Models\Competition::with(['participants', 'sources', 'historisations', 'disciplines'])->findOrFail(request()->route('competition'));
        }
        return view('livewire.competitions.show', compact('competition'));
    }
}
