<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreLieuRequest;
use App\Http\Requests\UpdateLieuRequest;
use App\Models\Lieu;

class LieuController extends BaseCrudController
{
    protected string $model = Lieu::class;
    protected array $relations = ['clubs', 'sources'];
    protected string $viewIndex = 'livewire.lieux.index';
    protected string $viewShow = 'livewire.lieux.show';
    protected string $viewCreate = 'livewire.lieux.create';
    protected string $viewEdit = 'livewire.lieux.edit';

    public function store(StoreLieuRequest $request)
    {
        $lieu = Lieu::create($request->validated());
        return redirect()->route('lieux.show', $lieu)->with('success', 'Lieu créé avec succès');
    }

    public function update(UpdateLieuRequest $request, $id)
    {
        $lieu = Lieu::findOrFail($id);
        $lieu->update($request->validated());
        return redirect()->route('lieux.show', $lieu)->with('success', 'Lieu modifié avec succès');
    }

    protected function detachRelations($entity)
    {
        $entity->clubs()->update(['siege_id' => null]);
    }
}
