<?php

namespace App\Livewire\Personnes;

use Livewire\Component;

use App\Models\Personne;
use App\Models\Club;
use App\Models\Lieu;

class Create extends Component
{
    public $nom;
    public $prenom;
    public $date_naissance;
    public $lieu_naissance_id;
    public $date_deces;
    public $lieu_deces_id;
    public $sexe;
    public $titre;
    public $adresse_id;
    public $clubs = [];
    public $disciplines = [];
    public $lieux = [];
    public $adresses = [];
    public $allClubs = [];
    public $allDisciplines = [];
    public $sources = [];
    public $allSources = [];

    public function mount()
    {
    $this->lieux = Lieu::all();
    $this->adresses = Lieu::all();
    $this->allClubs = Club::all();
    $this->allDisciplines = \App\Models\Discipline::all();
    $this->allSources = \App\Models\Source::all();
    }

    public function render()
    {
        return view('livewire.personnes.create', [
            'lieux' => $this->lieux,
            'adresses' => $this->adresses,
            'allClubs' => $this->allClubs,
            'disciplines' => $this->allDisciplines,
            'allSources' => $this->allSources,
        ]);
    }

    public function save()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'date_naissance' => 'nullable|string|max:10',
            'lieu_naissance_id' => 'nullable|exists:lieu,lieu_id',
            'date_deces' => 'nullable|string|max:10',
            'lieu_deces_id' => 'nullable|exists:lieu,lieu_id',
            'sexe' => 'nullable|string|max:10',
            'titre' => 'nullable|string|max:100',
            'adresse_id' => 'nullable|exists:lieu,lieu_id',
        ]);

        // Détection automatique de la précision des dates
        $dateNaissancePrecision = null;
        $dateDecesPrecision = null;
        if (preg_match('/^\d{4}$/', $this->date_naissance)) {
            $dateNaissancePrecision = 'year';
        } elseif (preg_match('/^\d{4}-\d{2}$/', $this->date_naissance)) {
            $dateNaissancePrecision = 'month';
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date_naissance)) {
            $dateNaissancePrecision = 'day';
        }
        if (preg_match('/^\d{4}$/', $this->date_deces)) {
            $dateDecesPrecision = 'year';
        } elseif (preg_match('/^\d{4}-\d{2}$/', $this->date_deces)) {
            $dateDecesPrecision = 'month';
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date_deces)) {
            $dateDecesPrecision = 'day';
        }

        $personne = Personne::create([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'date_naissance' => $this->date_naissance,
            'date_naissance_precision' => $dateNaissancePrecision,
            'lieu_naissance_id' => $this->lieu_naissance_id,
            'date_deces' => $this->date_deces,
            'date_deces_precision' => $dateDecesPrecision,
            'lieu_deces_id' => $this->lieu_deces_id,
            'sexe' => $this->sexe,
            'titre' => $this->titre,
            'adresse_id' => $this->adresse_id,
        ]);

        // Clubs (many-to-many)
        if (!empty($this->clubs)) {
            $personne->clubs()->sync($this->clubs);
        }

        // Disciplines (many-to-many)
        if (!empty($this->disciplines)) {
            $personne->disciplines()->sync($this->disciplines);
        }

        // Sources (many-to-many polymorphique)
        if (!empty($this->sources)) {
            $personne->sources()->syncWithPivotValues(
                array_map('intval', (array) $this->sources),
                ['entity_type' => 'personne']
            );
        }

        session()->flash('success', 'Personne créée avec succès.');
        return redirect()->route('personnes.index');
    }
}
