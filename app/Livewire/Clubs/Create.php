<?php

namespace App\Livewire\Clubs;

use Livewire\Component;
use App\Models\Club;
use App\Models\Personne;
use App\Models\Discipline;
use App\Models\Lieu;
use App\Models\Source;

class Create extends Component
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
    public $selectedSources = [];
    public $lieux = [];
    public $sources = [];
    public $personnes = [];
    public $disciplines = [];
    public $selectedPersonnes = [];
    public $selectedDisciplines = [];

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
            'selectedSources' => $this->selectedSources,
        ]);
    }

    public function save()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'siege_id' => 'nullable|exists:lieu,lieu_id',
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

        $club = Club::create([
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
            'siege_id' => $this->siege_id,
        ]);

        // Sources (morphToMany)
        $club->sources()->syncWithPivotValues(
            array_map('intval', (array) $this->selectedSources),
            ['entity_type' => 'club']
        );

        // Personnes (many-to-many)
        if (!empty($this->selectedPersonnes)) {
            $club->personnes()->sync($this->selectedPersonnes);
        }

        // Disciplines (many-to-many)
        if (!empty($this->selectedDisciplines)) {
            $club->disciplines()->sync($this->selectedDisciplines);
        }

        session()->flash('success', 'Club créé avec succès.');
        return redirect()->route('clubs.index');
    }
}
