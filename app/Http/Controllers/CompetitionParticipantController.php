<?php

namespace App\Http\Controllers;

use App\Models\CompetitionParticipant;
use Illuminate\Http\Request;

class CompetitionParticipantController extends Controller
{
    /**
     * Affiche la liste des participants de compétition.
     */
    public function index()
    {
        $participants = CompetitionParticipant::with(['competition', 'club', 'personne', 'source'])->get();
        return response()->json($participants);
    }

    /**
     * Ajoute un participant à une compétition.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'competition_id' => 'required|exists:competitions,competition_id',
            'club_id' => 'nullable|exists:clubs,club_id',
            'personne_id' => 'nullable|exists:personnes,personne_id',
            'resultat' => 'nullable|string|max:100',
            'source_id' => 'nullable|exists:sources,source_id',
        ]);
        // Vérification qu'un seul identifiant club ou personne est renseigné
        if (!empty($validated['club_id']) && !empty($validated['personne_id'])) {
            return response()->json(['error' => 'Un participant ne peut être à la fois un club et une personne.'], 422);
        }
        $participant = CompetitionParticipant::create($validated);
        return response()->json($participant, 201);
    }

    /**
     * Affiche un participant de compétition.
     */
    public function show(CompetitionParticipant $competition_participant)
    {
        $competition_participant->load(['competition', 'club', 'personne', 'source']);
        return response()->json($competition_participant);
    }

    /**
     * Met à jour un participant de compétition.
     */
    public function update(Request $request, CompetitionParticipant $competition_participant)
    {
        $validated = $request->validate([
            'competition_id' => 'sometimes|exists:competitions,competition_id',
            'club_id' => 'nullable|exists:clubs,club_id',
            'personne_id' => 'nullable|exists:personnes,personne_id',
            'resultat' => 'nullable|string|max:100',
            'source_id' => 'nullable|exists:sources,source_id',
        ]);
        if (!empty($validated['club_id']) && !empty($validated['personne_id'])) {
            return response()->json(['error' => 'Un participant ne peut être à la fois un club et une personne.'], 422);
        }
        $competition_participant->update($validated);
        return response()->json($competition_participant);
    }

    /**
     * Supprime un participant de compétition.
     */
    public function destroy(CompetitionParticipant $competition_participant)
    {
        $competition_participant->delete();
        return response()->json(['message' => 'Participant supprimé']);
    }
}
