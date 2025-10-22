<?php

namespace App\Livewire\Personnes;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $personnes = \App\Models\Personne::with(['clubs', 'disciplines', 'sources'])->paginate(15);
        return view('livewire.personnes.index', compact('personnes'));
    }
}
