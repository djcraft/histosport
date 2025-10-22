<?php

namespace App\Livewire\Sources;

use Livewire\Component;

class Show extends Component
{
    public function render()
    {
        $source = $this->source ?? null;
        if (!$source && request()->route('source')) {
            $source = \App\Models\Source::with(['clubs', 'personnes', 'disciplines', 'competitions', 'lieux', 'historisations'])->findOrFail(request()->route('source'));
        }
        return view('livewire.sources.show', compact('source'));
    }
}
