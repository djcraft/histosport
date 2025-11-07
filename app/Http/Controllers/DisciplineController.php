<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreDisciplineRequest;
use App\Http\Requests\UpdateDisciplineRequest;
use App\Models\Discipline;

class DisciplineController extends BaseCrudController
{
    protected string $model = Discipline::class;
    protected array $relations = ['clubs', 'personnes', 'sources'];
    protected string $viewIndex = 'livewire.disciplines.index';
    protected string $viewShow = 'livewire.disciplines.show';
    protected string $viewCreate = 'livewire.disciplines.create';
    protected string $viewEdit = 'livewire.disciplines.edit';

    public function store(StoreDisciplineRequest $request)
    {
        $discipline = Discipline::create($request->validated());
        return redirect()->route('disciplines.show', $discipline)->with('success', 'Discipline créée avec succès');
    }

    public function update(UpdateDisciplineRequest $request, $id)
    {
        $discipline = Discipline::findOrFail($id);
        $discipline->update($request->validated());
        return redirect()->route('disciplines.show', $discipline)->with('success', 'Discipline modifiée avec succès');
    }

    protected function detachRelations($entity)
    {
        $entity->clubs()->detach();
        $entity->personnes()->detach();
    }
}
