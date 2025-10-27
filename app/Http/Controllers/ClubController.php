<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClubRequest;
use App\Http\Requests\UpdateClubRequest;
use App\Models\Club;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Liste tous les clubs avec leurs relations principales.
     */
    public function index()
    {
        $clubs = Club::with(['siege', 'personnes', 'disciplines', 'competitions', 'sources', 'lieuxUtilises', 'sections'])->paginate(15);
        return view('livewire.clubs.index', compact('clubs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('livewire.clubs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Crée un nouveau club et historise l'action.
     */
    public function store(StoreClubRequest $request)
    {
        $club = Club::create($request->validated());
        return redirect()->route('clubs.show', $club)->with('success', 'Club créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Affiche un club avec ses relations.
     */
    public function destroy(Club $club)
    {
    // Nettoyage des relations pivots
    $club->personnes()->detach();
    $club->disciplines()->detach();
    // Suppression des participations du club à des compétitions
    \App\Models\CompetitionParticipant::where('club_id', $club->club_id)->delete();
    $club->sources()->detach();
    $club->lieuxUtilises()->detach();
    $club->sections()->detach();
    // Suppression du club
    $club->delete();
    return redirect()->route('clubs.index')->with('success', 'Club supprimé avec succès');
    }
    /**
     * Update the specified resource in storage.
     */
    /**
     * Met à jour un club et historise l'action.
     */
    public function update(UpdateClubRequest $request, Club $club)
    {
        $club->update($request->validated());
        return redirect()->route('clubs.show', $club)->with('success', 'Club modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Supprime un club et historise l'action.
     */
    // (Méthode destroy déjà adaptée plus haut, duplication supprimée)
}
