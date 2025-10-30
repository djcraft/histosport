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

    // Propriétés pour compatibilité avec le Blade
    public $selected_lieu_id = null;
    public $selected_personne_id = [];
    public $selected_discipline_id = [];
    public $selected_source_id = [];

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
            // Validation du siège via la propriété du search-bar
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

        // Conversion du siège en entier si tableau
        $siege_id = is_array($this->selected_lieu_id) ? (count($this->selected_lieu_id) ? $this->selected_lieu_id[count($this->selected_lieu_id)-1] : null) : $this->selected_lieu_id;

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
            'siege_id' => $siege_id,
        ]);

        // Sources (morphToMany)
        $club->sources()->syncWithPivotValues(
            array_map('intval', (array) $this->selected_source_id),
            ['entity_type' => 'club']
        );

        // Personnes (many-to-many)
        if (!empty($this->selected_personne_id)) {
            $club->personnes()->sync($this->selected_personne_id);
        }

        // Disciplines (many-to-many)
        if (!empty($this->selected_discipline_id)) {
            $club->disciplines()->sync($this->selected_discipline_id);
        }

        session()->flash('success', 'Club créé avec succès.');
        return redirect()->route('clubs.index');
    }
}
