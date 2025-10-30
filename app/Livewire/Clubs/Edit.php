<?php

namespace App\Livewire\Clubs;

use Livewire\Component;

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
    public $selected_personne_id = [];
    public $selected_discipline_id = [];
    public $selected_source_id = [];
    public $selected_lieu_id = null;

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

        // Initialisation des propriétés pour SearchBar
        $this->selected_personne_id = $club->personnes->pluck('personne_id')->toArray();
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
            'selectedPersonnes' => $this->selected_personne_id,
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
            $dateFondationPrecision = 'year';
        } elseif (preg_match('/^\d{4}-\d{2}$/', $this->date_fondation)) {
            $dateFondationPrecision = 'month';
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date_fondation)) {
            $dateFondationPrecision = 'day';
        }
        if (preg_match('/^\d{4}$/', $this->date_disparition)) {
            $dateDisparitionPrecision = 'year';
        } elseif (preg_match('/^\d{4}-\d{2}$/', $this->date_disparition)) {
            $dateDisparitionPrecision = 'month';
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date_disparition)) {
            $dateDisparitionPrecision = 'day';
        }
        if (preg_match('/^\d{4}$/', $this->date_declaration)) {
            $dateDeclarationPrecision = 'year';
        } elseif (preg_match('/^\d{4}-\d{2}$/', $this->date_declaration)) {
            $dateDeclarationPrecision = 'month';
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date_declaration)) {
            $dateDeclarationPrecision = 'day';
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

        // Personnes (many-to-many)
        if (!empty($this->selected_personne_id)) {
            $this->club->personnes()->sync($this->selected_personne_id);
        } else {
            $this->club->personnes()->sync([]);
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
}
