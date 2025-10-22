<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonneRequest;
use App\Http\Requests\UpdatePersonneRequest;
use App\Models\Personne;

class PersonneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Liste toutes les personnes avec leurs relations principales.
     */
    public function index()
    {
        $personnes = Personne::with(['clubs', 'disciplines', 'sources'])->paginate(15);
        return view('livewire.personnes.index', compact('personnes'));
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
     * Crée une nouvelle personne et historise l'action.
     */
    public function store(StorePersonneRequest $request)
    {
        $personne = Personne::create($request->validated());
        // Historisation
        $personne->historisations()->create([
            'entity_type' => 'personne',
            'entity_id' => $personne->personne_id,
            'utilisateur_id' => auth()->id(),
            'action' => 'création',
            'donnees_avant' => null,
            'donnees_apres' => json_encode($personne->toArray()),
        ]);
    return redirect()->route('personnes.show', $personne)->with('success', 'Personne créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Affiche une personne avec ses relations.
     */
    public function show(Personne $personne)
    {
        $personne->load(['clubs', 'disciplines', 'sources']);
    return view('livewire.personnes.show', compact('personne'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personne $personne)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Met à jour une personne et historise l'action.
     */
    public function update(UpdatePersonneRequest $request, Personne $personne)
    {
        $donnees_avant = $personne->toArray();
        $personne->update($request->validated());
        $donnees_apres = $personne->toArray();
        // Historisation
        $personne->historisations()->create([
            'entity_type' => 'personne',
            'entity_id' => $personne->personne_id,
            'utilisateur_id' => auth()->id(),
            'action' => 'modification',
            'donnees_avant' => json_encode($donnees_avant),
            'donnees_apres' => json_encode($donnees_apres),
        ]);
    return redirect()->route('personnes.show', $personne)->with('success', 'Personne modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Supprime une personne et historise l'action.
     */
    public function destroy(Personne $personne)
    {
        $donnees_avant = $personne->toArray();
        $personne->delete();
        // Historisation
        $personne->historisations()->create([
            'entity_type' => 'personne',
            'entity_id' => $personne->personne_id,
            'utilisateur_id' => auth()->id(),
            'action' => 'suppression',
            'donnees_avant' => json_encode($donnees_avant),
            'donnees_apres' => null,
        ]);
    return redirect()->route('personnes.index')->with('success', 'Personne supprimée avec succès');
    }
}
