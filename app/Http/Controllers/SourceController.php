<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreSourceRequest;
use App\Http\Requests\UpdateSourceRequest;
use App\Models\Source;

class SourceController extends BaseCrudController
{
    protected string $model = Source::class;
    protected array $relations = ['clubs', 'personnes', 'disciplines', 'competitions', 'lieux'];
    protected string $viewIndex = 'livewire.sources.index';
    protected string $viewShow = 'livewire.sources.show';
    protected string $viewCreate = 'livewire.sources.create';
    protected string $viewEdit = 'livewire.sources.edit';

    public function create()
    {
        $lieux = \App\Models\Lieu::all();
        return view('livewire.sources.create', compact('lieux'));
    }

    public function store(StoreSourceRequest $request)
    {
        $source = Source::create($request->validated());
        return redirect()->route('sources.show', $source)->with('success', 'Source créée avec succès');
    }

    public function update(UpdateSourceRequest $request, $id)
    {
        $source = Source::findOrFail($id);
        $source->update($request->validated());
        return redirect()->route('sources.show', $source)->with('success', 'Source modifiée avec succès');
    }

    protected function detachRelations($entity)
    {
        $entity->clubs()->detach();
        $entity->competitions()->detach();
        $entity->personnes()->detach();
        $entity->lieux()->detach();
    }
}
