<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompetitionRequest;
use App\Http\Requests\UpdateCompetitionRequest;
use App\Models\Competition;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Liste toutes les compétitions avec leurs relations principales.
     */
    public function index()
    {
        $competitions = Competition::with(['participants', 'sources'])->get();
        return response()->json($competitions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Crée une nouvelle compétition et historise l'action.
     */
    public function store(StoreCompetitionRequest $request)
    {
        $competition = Competition::create($request->validated());
        // Historisation
        $competition->historisations()->create([
            'entity_type' => 'competition',
            'entity_id' => $competition->competition_id,
            'utilisateur_id' => auth()->id(),
            'action' => 'création',
            'donnees_avant' => null,
            'donnees_apres' => json_encode($competition->toArray()),
        ]);
        return response()->json($competition, 201);
    }

    /**
     * Display the specified resource.
     */
    /**
     * Affiche une compétition avec ses relations.
     */
    public function show(Competition $competition)
    {
        $competition->load(['participants', 'sources']);
        return response()->json($competition);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Competition $competition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Met à jour une compétition et historise l'action.
     */
    public function update(UpdateCompetitionRequest $request, Competition $competition)
    {
        $donnees_avant = $competition->toArray();
        $competition->update($request->validated());
        $donnees_apres = $competition->toArray();
        // Historisation
        $competition->historisations()->create([
            'entity_type' => 'competition',
            'entity_id' => $competition->competition_id,
            'utilisateur_id' => auth()->id(),
            'action' => 'modification',
            'donnees_avant' => json_encode($donnees_avant),
            'donnees_apres' => json_encode($donnees_apres),
        ]);
        return response()->json($competition);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Supprime une compétition et historise l'action.
     */
    public function destroy(Competition $competition)
    {
        $donnees_avant = $competition->toArray();
        $competition->delete();
        // Historisation
        $competition->historisations()->create([
            'entity_type' => 'competition',
            'entity_id' => $competition->competition_id,
            'utilisateur_id' => auth()->id(),
            'action' => 'suppression',
            'donnees_avant' => json_encode($donnees_avant),
            'donnees_apres' => null,
        ]);
        return response()->json(['message' => 'Compétition supprimée']);
    }
}
