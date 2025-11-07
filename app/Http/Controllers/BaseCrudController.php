<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Contrôleur CRUD générique pour factorisation.
 * Les contrôleurs spécifiques héritent de cette classe et définissent les propriétés nécessaires.
 */
abstract class BaseCrudController extends Controller
{
    /**
     * Le modèle Eloquent à utiliser (ex: Club::class)
     */
    protected string $model;

    /**
     * Les relations à charger avec le modèle
     */
    protected array $relations = [];

    /**
     * Le nom de la vue index
     */
    protected string $viewIndex;

    /**
     * Le nom de la vue show
     */
    protected string $viewShow;

    /**
     * Le nom de la vue create
     */
    protected string $viewCreate;

    /**
     * Le nom de la vue edit
     */
    protected string $viewEdit;

    /**
     * Affiche la liste paginée des entités
     */
    public function index()
    {
        $entities = ($this->model)::with($this->relations)->paginate(15);
        return view($this->viewIndex, ['entities' => $entities]);
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view($this->viewCreate);
    }

    /**
     * Enregistre une nouvelle entité
     */
    public function store(Request $request)
    {
        $entity = ($this->model)::create($request->validated());
        return redirect()->route($this->getRouteShow(), $entity)->with('success', 'Création réussie');
    }

    /**
     * Affiche une entité
     */
    public function show($id)
    {
        $entity = ($this->model)::with($this->relations)->findOrFail($id);
        return view($this->viewShow, ['entity' => $entity]);
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit($id)
    {
        $entity = ($this->model)::findOrFail($id);
        return view($this->viewEdit, ['entity' => $entity]);
    }

    /**
     * Met à jour une entité
     */
    public function update(Request $request, $id)
    {
        $entity = ($this->model)::findOrFail($id);
        $entity->update($request->validated());
        return redirect()->route($this->getRouteShow(), $entity)->with('success', 'Modification réussie');
    }

    /**
     * Supprime une entité
     */
    public function destroy($id)
    {
        $entity = ($this->model)::findOrFail($id);
        $this->detachRelations($entity);
        $entity->delete();
        return redirect()->route($this->getRouteIndex())->with('success', 'Suppression réussie');
    }

    /**
     * Méthode à surcharger pour détacher les relations pivots
     */
    protected function detachRelations($entity)
    {
        // À surcharger dans les contrôleurs spécifiques si besoin
    }

    /**
     * Retourne le nom de la route index
     */
    protected function getRouteIndex(): string
    {
        return str_replace('.index', '', $this->viewIndex) . '.index';
    }

    /**
     * Retourne le nom de la route show
     */
    protected function getRouteShow(): string
    {
        return str_replace('.show', '', $this->viewShow) . '.show';
    }
}
