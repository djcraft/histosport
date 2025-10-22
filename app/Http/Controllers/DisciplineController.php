<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDisciplineRequest;
use App\Http\Requests\UpdateDisciplineRequest;
use App\Models\Discipline;

class DisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Liste toutes les disciplines avec leurs relations principales.
     */
    public function index()
    {
        $disciplines = Discipline::with(['clubs', 'personnes', 'sources'])->paginate(15);
        return view('livewire.disciplines.index', compact('disciplines'));
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
     * Crée une nouvelle discipline et historise l'action.
     */
    public function store(StoreDisciplineRequest $request)
    {
        $discipline = Discipline::create($request->validated());
        // Historisation
        $discipline->historisations()->create([
            'entity_type' => 'discipline',
            'entity_id' => $discipline->discipline_id,
            'utilisateur_id' => auth()->id(),
            'action' => 'création',
            'donnees_avant' => null,
            'donnees_apres' => json_encode($discipline->toArray()),
        ]);
    return redirect()->route('disciplines.show', $discipline)->with('success', 'Discipline créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Affiche une discipline avec ses relations.
     */
    public function show(Discipline $discipline)
    {
        $discipline->load(['clubs', 'personnes', 'sources']);
    return view('livewire.disciplines.show', compact('discipline'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discipline $discipline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Met à jour une discipline et historise l'action.
     */
    public function update(UpdateDisciplineRequest $request, Discipline $discipline)
    {
        $donnees_avant = $discipline->toArray();
        $discipline->update($request->validated());
        $donnees_apres = $discipline->toArray();
        // Historisation
        $discipline->historisations()->create([
            'entity_type' => 'discipline',
            'entity_id' => $discipline->discipline_id,
            'utilisateur_id' => auth()->id(),
            'action' => 'modification',
            'donnees_avant' => json_encode($donnees_avant),
            'donnees_apres' => json_encode($donnees_apres),
        ]);
    return redirect()->route('disciplines.show', $discipline)->with('success', 'Discipline modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Supprime une discipline et historise l'action.
     */
    public function destroy(Discipline $discipline)
    {
        $donnees_avant = $discipline->toArray();
        $discipline->delete();
        // Historisation
        $discipline->historisations()->create([
            'entity_type' => 'discipline',
            'entity_id' => $discipline->discipline_id,
            'utilisateur_id' => auth()->id(),
            'action' => 'suppression',
            'donnees_avant' => json_encode($donnees_avant),
            'donnees_apres' => null,
        ]);
    return redirect()->route('disciplines.index')->with('success', 'Discipline supprimée avec succès');
    }
}
