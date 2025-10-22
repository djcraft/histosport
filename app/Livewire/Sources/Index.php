<?php

namespace App\Livewire\Sources;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $sources = \App\Models\Source::with(['clubs', 'personnes', 'disciplines', 'competitions', 'lieux'])->paginate(15);
        return view('livewire.sources.index', compact('sources'));
    }
}
