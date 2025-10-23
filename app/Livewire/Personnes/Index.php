<?php

namespace App\Livewire\Personnes;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
    $personnes = \App\Models\Personne::with(['clubs', 'disciplines', 'adresse', 'lieu_naissance', 'lieu_deces'])->paginate(15);
        return view('livewire.personnes.index', compact('personnes'));
    }
}
