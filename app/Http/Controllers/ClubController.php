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
        // Historisation
        $club->historisations()->create([
            'entity_type' => 'club',
            'entity_id' => $club->club_id,
            'utilisateur_id' => auth()->id(),
            'action' => 'création',
            'donnees_avant' => null,
            'donnees_apres' => json_encode($club->toArray()),
        ]);
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
        $donnees_avant = $club->toArray();
        $club->delete();
        // Historisation
        $club->historisations()->create([
            'entity_type' => 'club',
            'entity_id' => $club->club_id,
            'utilisateur_id' => auth()->id(),
            'action' => 'suppression',
            'donnees_avant' => json_encode($donnees_avant),
            'donnees_apres' => null,
        ]);
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
        $donnees_avant = $club->toArray();
        $club->update($request->validated());
        $donnees_apres = $club->toArray();
        // Historisation
            $club->historisations()->create([
                'entity_type' => 'club',
                'entity_id' => $club->club_id,
                'utilisateur_id' => auth()->id(),
                'action' => 'modification',
                'donnees_avant' => json_encode($donnees_avant),
                'donnees_apres' => json_encode($donnees_apres),
            ]);
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
