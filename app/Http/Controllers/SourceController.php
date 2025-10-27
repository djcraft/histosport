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
        $sources = Source::with(['clubs', 'personnes', 'disciplines', 'competitions', 'lieux'])->paginate(15);
        return view('livewire.sources.index', compact('sources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $lieux = \App\Models\Lieu::all();
    return view('livewire.sources.create', compact('lieux'));
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
    return redirect()->route('sources.show', $source)->with('success', 'Source créée avec succès');
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
    return view('livewire.sources.show', compact('source'));
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
        $source->update($request->validated());
    return redirect()->route('sources.show', $source)->with('success', 'Source modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Supprime une source et historise l'action.
     */
    public function destroy(Source $source)
    {
        // Nettoyage des relations pivots
        $source->clubs()->detach();
        $source->competitions()->detach();
        $source->personnes()->detach();
        $source->lieux()->detach();
        // Suppression de la source
        $source->delete();
        return redirect()->route('sources.index')->with('success', 'Source supprimée avec succès');
    }
}
