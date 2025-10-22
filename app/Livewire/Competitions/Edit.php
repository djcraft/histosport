<?php

namespace App\Livewire\Competitions;

use Livewire\Component;

class Edit extends Component
{
    public function render()
    {
    $allSources = \App\Models\Source::all();
    $lieux = \App\Models\Lieu::all();
    $clubs = \App\Models\Club::all();
    $personnes = \App\Models\Personne::all();
    $allDisciplines = \App\Models\Discipline::all();
    $allParticipants = \App\Models\CompetitionParticipant::all();
    return view('livewire.competitions.edit', compact('allSources', 'lieux', 'clubs', 'personnes', 'allDisciplines', 'allParticipants'));
    }
}
