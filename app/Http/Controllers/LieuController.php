<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLieuRequest;
use App\Http\Requests\UpdateLieuRequest;
use App\Models\Lieu;

class LieuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Liste tous les lieux avec leurs relations principales.
     */
    public function index()
    {
        $lieux = Lieu::with(['clubs', 'sources'])->paginate(15);
        return view('livewire.lieux.index', compact('lieux'));
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
     * Crée un nouveau lieu et historise l'action.
     */
    public function store(StoreLieuRequest $request)
    {
        $lieu = Lieu::create($request->validated());
    return redirect()->route('lieux.show', $lieu)->with('success', 'Lieu créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Affiche un lieu avec ses relations.
     */
    public function show(Lieu $lieu)
    {
        $lieu->load(['clubs', 'sources']);
    return view('livewire.lieux.show', compact('lieu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lieu $lieu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Met à jour un lieu et historise l'action.
     */
    public function update(UpdateLieuRequest $request, Lieu $lieu)
    {
        $lieu->update($request->validated());
    return redirect()->route('lieux.show', $lieu)->with('success', 'Lieu modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Supprime un lieu et historise l'action.
     */
    public function destroy(Lieu $lieu)
    {
        // Nettoyage des relations pivots
        $lieu->clubs()->update(['siege_id' => null]);
        // Suppression du lieu
        $lieu->delete();
        return redirect()->route('lieux.index')->with('success', 'Lieu supprimé avec succès');
    }
}
