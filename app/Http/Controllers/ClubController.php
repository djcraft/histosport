<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreClubRequest;
use App\Http\Requests\UpdateClubRequest;
use App\Models\Club;

class ClubController extends BaseCrudController
{
    protected string $model = Club::class;
    protected array $relations = ['siege', 'personnes', 'disciplines', 'competitions', 'sources', 'lieuxUtilises', 'sections'];
    protected string $viewIndex = 'livewire.clubs.index';
    protected string $viewShow = 'livewire.clubs.show';
    protected string $viewCreate = 'livewire.clubs.create';
    protected string $viewEdit = 'livewire.clubs.edit';

    /**
     * Surcharge pour utiliser les FormRequest Laravel
     */
    public function store(\Illuminate\Http\Request $request)
    {
        // Si le request est une instance de StoreClubRequest, on valide
        if ($request instanceof \App\Http\Requests\StoreClubRequest) {
            $validated = $request->validated();
        } else {
            $validated = $request->validate(\App\Rules\ClubRules::rules());
        }
        $entity = Club::create($validated);
        return redirect()->route('clubs.show', $entity)->with('success', 'Club créé avec succès');
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $entity = Club::findOrFail($id);
        $validated = (new UpdateClubRequest())->rules();
        $request->validate($validated);
        $entity->update($request->all());
        return redirect()->route('clubs.show', $entity)->with('success', 'Club modifié avec succès');
    }

    /**
     * Nettoyage des relations pivots et suppression des participations
     */
    protected function detachRelations($entity)
    {
        $entity->personnes()->detach();
        $entity->disciplines()->detach();
        \App\Models\CompetitionParticipant::where('club_id', $entity->club_id)->delete();
        $entity->sources()->detach();
        $entity->lieuxUtilises()->detach();
        $entity->sections()->detach();
    }
}
