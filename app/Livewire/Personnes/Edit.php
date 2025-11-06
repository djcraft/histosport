<?php

namespace App\Livewire\Personnes;

use App\Livewire\BaseCrudComponent;
use App\Models\Personne;
use App\Models\Club;
use App\Models\Lieu;
use App\Livewire\Actions\ValidateForm;
use App\Livewire\Actions\Notify;
use App\Livewire\Actions\SyncRelations;

class Edit extends BaseCrudComponent
{
    public $personne;
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
    
    protected $rules = [
        'nom' => 'required|string|max:255',
        'prenom' => 'nullable|string|max:255',
        'date_naissance' => 'nullable|string|max:10',
        'date_naissance_precision' => 'nullable|string|max:20',
        'lieu_naissance_id' => 'nullable|exists:lieu,lieu_id',
        'date_deces' => 'nullable|string|max:10',
        'date_deces_precision' => 'nullable|string|max:20',
        'lieu_deces_id' => 'nullable|exists:lieu,lieu_id',
        'sexe' => 'nullable|string|max:10',
        'titre' => 'nullable|string|max:100',
        'adresse_id' => 'nullable|exists:lieu,lieu_id',
    ];

    public function mount(Personne $personne)
    {
        $this->personne = $personne;
        $this->nom = $personne->nom;
        $this->prenom = $personne->prenom;
        $this->date_naissance = $personne->date_naissance;
        $this->lieu_naissance_id = $personne->lieu_naissance_id;
        $this->date_deces = $personne->date_deces;
        $this->lieu_deces_id = $personne->lieu_deces_id;
        $this->sexe = $personne->sexe;
        $this->titre = $personne->titre;
        $this->adresse_id = $personne->adresse_id;
    $this->clubs = $personne->clubs->pluck('club_id')->toArray();
    $this->disciplines = $personne->disciplines->pluck('discipline_id')->toArray();
    $this->sources = $personne->sources->pluck('source_id')->toArray();
    $this->lieux = Lieu::all();
    $this->adresses = Lieu::all();
    $this->allClubs = Club::all();
    $this->allDisciplines = \App\Models\Discipline::all();
    $this->allSources = \App\Models\Source::all();
    }

    public function render()
    {
        return view('livewire.personnes.edit', [
            'lieux' => $this->lieux,
            'adresses' => $this->adresses,
            'allClubs' => $this->allClubs,
            'disciplines' => $this->allDisciplines,
            'allSources' => $this->allSources,
        ]);
    }

    public function update()
    {
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

        $lieuNaissanceId = is_array($this->lieu_naissance_id)
            ? (count($this->lieu_naissance_id) ? $this->lieu_naissance_id[0] : null)
            : (is_object($this->lieu_naissance_id) && isset($this->lieu_naissance_id->lieu_id) ? (int)$this->lieu_naissance_id->lieu_id : (is_scalar($this->lieu_naissance_id) ? (int)$this->lieu_naissance_id : null));
        $lieuDecesId = is_array($this->lieu_deces_id)
            ? (count($this->lieu_deces_id) ? $this->lieu_deces_id[0] : null)
            : (is_object($this->lieu_deces_id) && isset($this->lieu_deces_id->lieu_id) ? (int)$this->lieu_deces_id->lieu_id : (is_scalar($this->lieu_deces_id) ? (int)$this->lieu_deces_id : null));
        $adresseId = is_array($this->adresse_id)
            ? (count($this->adresse_id) ? $this->adresse_id[0] : null)
            : (is_object($this->adresse_id) && isset($this->adresse_id->lieu_id) ? (int)$this->adresse_id->lieu_id : (is_scalar($this->adresse_id) ? (int)$this->adresse_id : null));

        $this->form = [
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'date_naissance' => $this->date_naissance,
            'date_naissance_precision' => $dateNaissancePrecision,
            'lieu_naissance_id' => $lieuNaissanceId,
            'date_deces' => $this->date_deces,
            'date_deces_precision' => $dateDecesPrecision,
            'lieu_deces_id' => $lieuDecesId,
            'sexe' => $this->sexe,
            'titre' => $this->titre,
            'adresse_id' => $adresseId,
        ];

        // Validation mutualisée
        $validated = ValidateForm::run($this->form, $this->rules);
        $this->personne->update($validated);

        // Synchronisation des relations mutualisée
        SyncRelations::run($this->personne, [
            'clubs' => $this->clubs,
            'disciplines' => $this->disciplines,
            'sources' => $this->sources,
        ]);

        // Notification mutualisée
        Notify::run('Personne modifiée avec succès.');
        return redirect()->route('personnes.index');
    }
}
