<?php

namespace App\Livewire\Lieux;

use Livewire\Component;

class Show extends Component
{
    public function render()
    {
        $lieu = $this->lieu ?? null;
        if (!$lieu && request()->route('lieu')) {
            $lieu = \App\Models\Lieu::with(['clubs'])->findOrFail(request()->route('lieu'));
        }
        return view('livewire.lieux.show', compact('lieu'));
    }
}
