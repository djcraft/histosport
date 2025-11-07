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

    public function store(\Illuminate\Http\Request $request)
    {
        if ($request instanceof \App\Http\Requests\StoreSourceRequest) {
            $validated = $request->validated();
        } else {
            $validated = $request->validate(\App\Rules\SourceRules::rules());
        }
        $source = Source::create($validated);
        return redirect()->route('sources.show', $source)->with('success', 'Source créée avec succès');
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $source = Source::findOrFail($id);
        $validated = (new UpdateSourceRequest())->rules();
        $request->validate($validated);
        $source->update($request->all());
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
