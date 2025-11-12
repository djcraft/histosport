<?php

namespace App\Livewire\Clubs;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Show extends Component
{
    public function render()
    {
        $club = $this->club ?? null;
        if (!$club && request()->route('club')) {
            $club = \App\Models\Club::with([
                'disciplines',
                'personnes',
                'sources',
                'siege',
                'competitionParticipants.competition'
            ])->findOrFail(request()->route('club'));
        }
        // Debug : log le contenu des sources
    Log::debug('Club sources', [
            'club_id' => $club?->club_id,
            'sources' => $club?->sources?->toArray(),
        ]);
        return view('livewire.clubs.show', compact('club'));
    }
}
