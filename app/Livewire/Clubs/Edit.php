<?php

namespace App\Livewire\Clubs;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use App\Models\Club;
use App\Models\Personne;
use App\Models\Discipline;
use App\Models\Lieu;
use App\Models\Source;

class Edit extends Component
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
        $this->validate([
            'nom' => 'required|string|max:255',
            'selected_lieu_id' => 'nullable|exists:lieu,lieu_id',
        ]);

        // Détection automatique de la précision des dates
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

        $this->club->update([
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
            'siege_id' => $this->selected_lieu_id,
        ]);

        // Sources (morphToMany)
        $this->club->sources()->syncWithPivotValues(
            array_map('intval', (array) $this->selected_source_id),
            ['entity_type' => 'club']
        );
        $this->club->refresh();
        $this->club->load('sources');

        // Mandats datés (clubPersonnes) + présence simple fusionnés
        $mandatsToInsert = [];
        $mandatPersonneIds = [];
        // Mandats datés : chaque mandat est une ligne
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
        // Présence simple : une ligne par personne non déjà présente dans les mandats datés
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
        $ids = array_filter($ids); // retire les 0 ou null
        foreach ($ids as $id) {
            // Toujours ajouter une ligne de présence simple, même si la personne a déjà un mandat daté
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
        // On supprime tous les mandats existants pour ce club
        DB::table('club_personne')->where('club_id', $this->club->club_id)->delete();
        // On ajoute chaque mandat individuellement (plusieurs lignes par personne/club possible)
        foreach ($mandatsToInsert as $pivot) {
            DB::table('club_personne')->insert($pivot);
        }

        // Disciplines (many-to-many)
        if (!empty($this->selected_discipline_id)) {
            $this->club->disciplines()->sync($this->selected_discipline_id);
        } else {
            $this->club->disciplines()->sync([]);
        }

        session()->flash('success', 'Club mis à jour avec succès.');
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
