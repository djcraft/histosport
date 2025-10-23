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
        $competitions = Competition::with(['participants', 'sources'])->paginate(15);
        return view('livewire.competitions.index', compact('competitions'));
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
    return redirect()->route('competitions.show', $competition)->with('success', 'Compétition créée avec succès');
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
    return view('livewire.competitions.show', compact('competition'));
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
        $competition->update($request->validated());
    return redirect()->route('competitions.show', $competition)->with('success', 'Compétition modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Supprime une compétition et historise l'action.
     */
    public function destroy(Competition $competition)
    {
        $competition->delete();
    return redirect()->route('competitions.index')->with('success', 'Compétition supprimée avec succès');
    }
}
