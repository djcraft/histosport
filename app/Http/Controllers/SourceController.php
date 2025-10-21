<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSourceRequest;
use App\Http\Requests\UpdateSourceRequest;
use App\Models\Source;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Liste toutes les sources avec leurs relations principales.
     */
    public function index()
    {
        $sources = Source::with(['clubs', 'personnes', 'disciplines', 'competitions', 'lieux'])->get();
        return response()->json($sources);
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
     * Crée une nouvelle source et historise l'action.
     */
    public function store(StoreSourceRequest $request)
    {
        $source = Source::create($request->validated());
        // Historisation
        $source->historisations()->create([
            'entity_type' => 'source',
            'entity_id' => $source->source_id,
            'utilisateur_id' => auth()->id(),
            'action' => 'création',
            'donnees_avant' => null,
            'donnees_apres' => json_encode($source->toArray()),
        ]);
        return response()->json($source, 201);
    }

    /**
     * Display the specified resource.
     */
    /**
     * Affiche une source avec ses relations.
     */
    public function show(Source $source)
    {
        $source->load(['clubs', 'personnes', 'disciplines', 'competitions', 'lieux']);
        return response()->json($source);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Source $source)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Met à jour une source et historise l'action.
     */
    public function update(UpdateSourceRequest $request, Source $source)
    {
        $donnees_avant = $source->toArray();
        $source->update($request->validated());
        $donnees_apres = $source->toArray();
        // Historisation
        $source->historisations()->create([
            'entity_type' => 'source',
            'entity_id' => $source->source_id,
            'utilisateur_id' => auth()->id(),
            'action' => 'modification',
            'donnees_avant' => json_encode($donnees_avant),
            'donnees_apres' => json_encode($donnees_apres),
        ]);
        return response()->json($source);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Supprime une source et historise l'action.
     */
    public function destroy(Source $source)
    {
        $donnees_avant = $source->toArray();
        $source->delete();
        // Historisation
        $source->historisations()->create([
            'entity_type' => 'source',
            'entity_id' => $source->source_id,
            'utilisateur_id' => auth()->id(),
            'action' => 'suppression',
            'donnees_avant' => json_encode($donnees_avant),
            'donnees_apres' => null,
        ]);
        return response()->json(['message' => 'Source supprimée']);
    }
}
