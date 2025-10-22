<?php

namespace App\Livewire\Sources;

use Livewire\Component;

class Edit extends Component
{
    public function render()
    {
    $lieux = \App\Models\Lieu::all();
    $allLieux = \App\Models\Lieu::all();
    $allPersonnes = \App\Models\Personne::all();
    $allDisciplines = \App\Models\Discipline::all();
    $allCompetitions = \App\Models\Competition::all();
    return view('livewire.sources.edit', compact('lieux', 'allLieux', 'allPersonnes', 'allDisciplines', 'allCompetitions'));
    }
}
