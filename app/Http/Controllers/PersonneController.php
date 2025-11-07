<?php


namespace App\Http\Controllers;

use App\Http\Requests\StorePersonneRequest;
use App\Http\Requests\UpdatePersonneRequest;
use App\Models\Personne;

class PersonneController extends BaseCrudController
{
    protected string $model = Personne::class;
    protected array $relations = ['clubs', 'disciplines', 'sources'];
    protected string $viewIndex = 'livewire.personnes.index';
    protected string $viewShow = 'livewire.personnes.show';
    protected string $viewCreate = 'livewire.personnes.create';
    protected string $viewEdit = 'livewire.personnes.edit';

    public function store(StorePersonneRequest $request)
    {
        $personne = Personne::create($request->validated());
        return redirect()->route('personnes.show', $personne)->with('success', 'Personne créée avec succès');
    }

    public function update(UpdatePersonneRequest $request, $id)
    {
        $personne = Personne::findOrFail($id);
        $personne->update($request->validated());
        return redirect()->route('personnes.show', $personne)->with('success', 'Personne modifiée avec succès');
    }

    protected function detachRelations($entity)
    {
        $entity->clubs()->detach();
        $entity->disciplines()->detach();
    }
}
