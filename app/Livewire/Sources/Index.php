<?php

namespace App\Livewire\Sources;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $sources = \App\Models\Source::with([
            'clubs',
            'personnes',
            'competitions',
            'lieux',
            'lieuEdition',
            'lieuConservation',
            'lieuCouverture',
        ])->paginate(15);
        return view('livewire.sources.index', compact('sources'));
    }
}
