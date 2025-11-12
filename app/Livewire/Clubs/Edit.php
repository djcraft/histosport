<?php

namespace App\Livewire\Clubs;

use App\Livewire\BaseCrudComponent;
use Illuminate\Support\Facades\DB;
use App\Models\Club;
use App\Models\Personne;
use App\Models\Discipline;
use App\Models\Lieu;
use App\Models\Source;
use App\Livewire\Actions\ValidateForm;
use App\Livewire\Actions\Notify;
use App\Livewire\Actions\SyncRelations;

class Edit extends BaseCrudComponent
{
    public $club;
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
    public $sources = [];
    public $personnes = [];
    public $disciplines = [];
    public $lieux = [];

    // Propriétés liées aux champs cachés SearchBar
    // Pour la gestion des mandats datés
    public $clubPersonnes = [];
    public $selected_discipline_id = [];
    public $selected_source_id = [];
    public $selected_lieu_id = null;
    // Pour la gestion de la présence simple (multi-select)
    public $selected_personne_id = [];

    protected function rules()
    {
        return \App\Rules\ClubRules::rules();
    }

    protected $listeners = [
        'lieuCreated' => 'onLieuCreated',
        'disciplineCreated' => 'onDisciplineCreated',
        'sourceCreated' => 'onSourceCreated',
    ];
    public function onSourceCreated($id)
    {
        $this->sources = Source::all();
        $this->selected_source_id[] = $id;
    }
    public function onDisciplineCreated($id)
    {
        $this->disciplines = Discipline::all();
        $this->selected_discipline_id[] = $id;
    }

    public function onLieuCreated($id)
    {
        $this->lieux = Lieu::all();
        $this->selected_lieu_id = $id;
    }

    public function mount(Club $club)
    {
        $club->load('sources');
        $this->club = $club;
        $this->nom = $club->nom;
        $this->nom_origine = $club->nom_origine;
        $this->surnoms = $club->surnoms;
        $this->date_fondation = $club->date_fondation;
        $this->date_disparition = $club->date_disparition;
        $this->date_declaration = $club->date_declaration;
        $this->acronyme = $club->acronyme;
        $this->couleurs = $club->couleurs;
        $this->notes = $club->notes;
        $this->siege_id = $club->siege_id;
        $this->sources = Source::all();
        $this->personnes = Personne::all();
        $this->disciplines = Discipline::all();
        $this->lieux = Lieu::all();

        // Séparation mandats datés / présence simple
        $this->clubPersonnes = [];
        $this->selected_personne_id = [];
        if ($club->clubPersonnes) {
            foreach ($club->clubPersonnes as $mandat) {
                $isSimple = empty($mandat->role)
                    && empty($mandat->date_debut)
                    && empty($mandat->date_debut_precision)
                    && empty($mandat->date_fin)
                    && empty($mandat->date_fin_precision);
                if ($isSimple) {
                    $this->selected_personne_id[] = $mandat->personne_id;
                } else {
                    $this->clubPersonnes[] = [
                        'personne_id' => $mandat->personne_id,
                        'role' => $mandat->role,
                        'date_debut' => $mandat->date_debut,
                        'date_debut_precision' => $mandat->date_debut_precision,
                        'date_fin' => $mandat->date_fin,
                        'date_fin_precision' => $mandat->date_fin_precision,
                    ];
                }
            }
        }
        $this->selected_discipline_id = $club->disciplines->pluck('discipline_id')->toArray();
        $this->selected_source_id = $club->sources->pluck('source_id')->toArray();
        $this->selected_lieu_id = $club->siege_id;
    }

    public function render()
    {
        return view('livewire.clubs.edit', [
            'lieux' => $this->lieux,
            'sources' => $this->sources,
            'personnes' => $this->personnes,
            'disciplines' => $this->disciplines,
            'clubPersonnes' => $this->clubPersonnes,
            'selectedDisciplines' => $this->selected_discipline_id,
            'selectedSources' => $this->selected_source_id,
            'siege_id' => $this->selected_lieu_id,
        ]);
    }

    public function update()
    {
        // Préparation des données du formulaire
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

        $siege_id = is_array($this->selected_lieu_id) ? (count($this->selected_lieu_id) ? intval($this->selected_lieu_id[0]) : null) : $this->selected_lieu_id;
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
        $validated = ValidateForm::run($this->form, $this->rules());
        $this->club->update($validated);

        // Synchronisation des relations mutualisée
        SyncRelations::run($this->club, [
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
                    'club_id' => $this->club->club_id,
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
                'club_id' => $this->club->club_id,
                'personne_id' => $id,
                'role' => null,
                'date_debut' => null,
                'date_debut_precision' => null,
                'date_fin' => null,
                'date_fin_precision' => null,
            ];
        }
        DB::table('club_personne')->where('club_id', $this->club->club_id)->delete();
        foreach ($mandatsToInsert as $pivot) {
            DB::table('club_personne')->insert($pivot);
        }

        // Notification mutualisée
        Notify::run('Club mis à jour avec succès.');
        return redirect()->route('clubs.index');
    }

    // Méthode pour ajouter un mandat
    public function addClubPersonne()
    {
        $newMandat = [
            'personne_id' => null,
            'role' => null,
            'date_debut' => null,
            'date_debut_precision' => 'année',
            'date_fin' => null,
            'date_fin_precision' => 'année',
        ];
        $this->clubPersonnes[] = $newMandat;
    }


    // Méthode pour supprimer un mandat
    public function removeClubPersonne($index)
    {
        unset($this->clubPersonnes[$index]);
        $this->clubPersonnes = array_values($this->clubPersonnes);
    }
}
