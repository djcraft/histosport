<?php

namespace App\Livewire\Clubs;

use App\Livewire\BaseCrudComponent;
use App\Models\Club;
use App\Models\Personne;
use App\Models\Discipline;
use App\Models\Lieu;
use App\Models\Source;
use App\Livewire\Actions\ValidateForm;
use App\Livewire\Actions\Notify;
use App\Livewire\Actions\SyncRelations;

class Create extends BaseCrudComponent
{
    public $nom;
    public $nom_origine;
    public $surnoms;
    public $date_fondation;
    public $date_disparition;
    public $date_declaration;
    public $acronyme;
    public $couleurs;
    public $notes;
    public $siege_id;
    public $lieux = [];
    public $sources = [];
    public $personnes = [];
    public $disciplines = [];
    public $selected_lieu_id = null;
    public $selected_personne_id = [];
    public $selected_discipline_id = [];
    public $selected_source_id = [];
    // Mandats datés
    public $clubPersonnes = [];

    protected $rules = [
        'nom' => 'required|string|max:255',
        'nom_origine' => 'nullable|string|max:255',
        'surnoms' => 'nullable|string|max:255',
        'date_fondation' => 'nullable|string|max:255',
        'date_fondation_precision' => 'nullable|string|max:20',
        'date_disparition' => 'nullable|string|max:255',
        'date_disparition_precision' => 'nullable|string|max:20',
        'date_declaration' => 'nullable|string|max:255',
        'date_declaration_precision' => 'nullable|string|max:20',
        'acronyme' => 'nullable|string|max:255',
        'couleurs' => 'nullable|string|max:255',
        'siege_id' => 'nullable|integer|exists:lieu,lieu_id',
        'notes' => 'nullable|string|max:1000',
    ];

    protected $listeners = [
        'lieuCreated' => 'onLieuCreated',
        'disciplineCreated' => 'onDisciplineCreated',
        'sourceCreated' => 'onSourceCreated',
    ];
    public function onLieuCreated($id)
    {
        $this->lieux = Lieu::all();
        $this->selected_lieu_id = $id;
    }

    public function onDisciplineCreated($id)
    {
    $this->disciplines = Discipline::all();
    $this->selected_discipline_id[] = $id;
    }

    public function onSourceCreated($id)
    {
        $this->sources = Source::all();
        $this->selected_source_id[] = $id;
    }

    public function mount()
    {
        $this->lieux = Lieu::all();
        $this->sources = Source::all();
        $this->personnes = Personne::all();
        $this->disciplines = Discipline::all();
    }

    public function render()
    {
        return view('livewire.clubs.create', [
            'lieux' => $this->lieux,
            'sources' => $this->sources,
            'personnes' => $this->personnes,
            'disciplines' => $this->disciplines,
            'clubPersonnes' => $this->clubPersonnes,
        ]);
    }

    public function save()
    {
        // Préparation des données du formulaire
        $siege_id = is_array($this->selected_lieu_id) ? (count($this->selected_lieu_id) ? $this->selected_lieu_id[count($this->selected_lieu_id)-1] : null) : $this->selected_lieu_id;
        $dateFondationPrecision = null;
        $dateDisparitionPrecision = null;
        $dateDeclarationPrecision = null;
        if (preg_match('/^\d{4}$/', $this->date_fondation)) {
            $dateFondationPrecision = 'année';
        } elseif (preg_match('/^\d{4}-\d{2}$/', $this->date_fondation)) {
            $dateFondationPrecision = 'mois';
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date_fondation)) {
            $dateFondationPrecision = 'jour';
        }
        if (preg_match('/^\d{4}$/', $this->date_disparition)) {
            $dateDisparitionPrecision = 'année';
        } elseif (preg_match('/^\d{4}-\d{2}$/', $this->date_disparition)) {
            $dateDisparitionPrecision = 'mois';
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date_disparition)) {
            $dateDisparitionPrecision = 'jour';
        }
        if (preg_match('/^\d{4}$/', $this->date_declaration)) {
            $dateDeclarationPrecision = 'année';
        } elseif (preg_match('/^\d{4}-\d{2}$/', $this->date_declaration)) {
            $dateDeclarationPrecision = 'mois';
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date_declaration)) {
            $dateDeclarationPrecision = 'jour';
        }


        $this->form = [
            'nom' => $this->nom,
            'nom_origine' => $this->nom_origine,
            'surnoms' => $this->surnoms,
            'date_fondation' => $this->date_fondation,
            'date_fondation_precision' => $dateFondationPrecision,
            'date_disparition' => $this->date_disparition,
            'date_disparition_precision' => $dateDisparitionPrecision,
            'date_declaration' => $this->date_declaration,
            'date_declaration_precision' => $dateDeclarationPrecision,
            'acronyme' => $this->acronyme,
            'couleurs' => $this->couleurs,
            'notes' => $this->notes,
            'siege_id' => $siege_id,
        ];
        // Validation mutualisée
        $validated = ValidateForm::run($this->form, $this->rules);
        $club = Club::create($validated);

        // Synchronisation des relations mutualisée
        SyncRelations::run($club, [
            'sources' => $this->selected_source_id,
            'disciplines' => $this->selected_discipline_id,
        ]);

        // Gestion des mandats datés (spécifique)
        $mandatsToInsert = [];
        $mandatPersonneIds = [];
        foreach ($this->clubPersonnes as $mandat) {
            $personneId = null;
            if (is_array($mandat) && isset($mandat['personne_id'])) {
                $personneId = (int)$mandat['personne_id'];
            } elseif (is_object($mandat) && isset($mandat->personne_id)) {
                $personneId = (int)$mandat->personne_id;
            }
            if ($personneId) {
                $mandatsToInsert[] = [
                    'personne_id' => $personneId,
                    'role' => $mandat['role'] ?? null,
                    'date_debut' => $mandat['date_debut'] ?? null,
                    'date_debut_precision' => $mandat['date_debut_precision'] ?? null,
                    'date_fin' => $mandat['date_fin'] ?? null,
                    'date_fin_precision' => $mandat['date_fin_precision'] ?? null,
                ];
                $mandatPersonneIds[] = $personneId;
            }
        }
        $ids = array_map(function($item) {
            if (is_array($item) && isset($item['personne_id'])) {
                return (int)$item['personne_id'];
            }
            if (is_object($item) && isset($item->personne_id)) {
                return (int)$item->personne_id;
            }
            if (is_scalar($item)) {
                return (int)$item;
            }
            return null;
        }, $this->selected_personne_id);
        $ids = array_filter($ids);
        foreach ($ids as $id) {
            $mandatsToInsert[] = [
                'personne_id' => $id,
                'role' => null,
                'date_debut' => null,
                'date_debut_precision' => null,
                'date_fin' => null,
                'date_fin_precision' => null,
            ];
        }
        if (!empty($mandatsToInsert)) {
            $club->personnes()->detach();
            foreach ($mandatsToInsert as $pivot) {
                $club->personnes()->attach($pivot['personne_id'], [
                    'role' => $pivot['role'],
                    'date_debut' => $pivot['date_debut'],
                    'date_debut_precision' => $pivot['date_debut_precision'],
                    'date_fin' => $pivot['date_fin'],
                    'date_fin_precision' => $pivot['date_fin_precision'],
                ]);
            }
        }

        // Notification mutualisée
        Notify::run('Club créé avec succès.');
        return redirect()->route('clubs.index');
    }

    // Ajout d’un mandat daté
    public function addClubPersonne()
    {
        $this->clubPersonnes[] = [
            'personne_id' => null,
            'role' => null,
            'date_debut' => null,
            'date_debut_precision' => 'année',
            'date_fin' => null,
            'date_fin_precision' => 'année',
        ];
    }

    // Suppression d’un mandat daté
    public function removeClubPersonne($index)
    {
        unset($this->clubPersonnes[$index]);
        $this->clubPersonnes = array_values($this->clubPersonnes);
    }
}
