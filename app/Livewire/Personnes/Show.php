<?php

namespace App\Livewire\Personnes;

use Livewire\Component;

class Show extends Component
{
    public function render()
    {
        // Récupération de la personne à afficher (id via route ou propriété)
        $personne = $this->personne ?? null;
        if (!$personne && request()->route('personne')) {
            $personne = \App\Models\Personne::with(['clubs', 'disciplines'])->findOrFail(request()->route('personne'));
        }
        return view('livewire.personnes.show', compact('personne'));
    }
}
