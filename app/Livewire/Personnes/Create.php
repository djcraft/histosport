<?php

namespace App\Livewire\Personnes;

use App\Livewire\BaseCrudComponent;
use App\Models\Personne;
use App\Models\Club;
use App\Models\Lieu;
use App\Livewire\Actions\ValidateForm;
use App\Livewire\Actions\Notify;
use App\Livewire\Actions\SyncRelations;

class Create extends BaseCrudComponent
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
    
        protected function rules()
        {
            return \App\Rules\PersonneRules::rules();
        }

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

        // Conversion des IDs en entier ou null
        $lieu_naissance_id = is_array($this->lieu_naissance_id)
            ? (count($this->lieu_naissance_id) ? (int)$this->lieu_naissance_id[0] : null)
            : (is_object($this->lieu_naissance_id) && isset($this->lieu_naissance_id->lieu_id) ? (int)$this->lieu_naissance_id->lieu_id : (is_scalar($this->lieu_naissance_id) ? (int)$this->lieu_naissance_id : null));
        $lieu_deces_id = is_array($this->lieu_deces_id)
            ? (count($this->lieu_deces_id) ? (int)$this->lieu_deces_id[0] : null)
            : (is_object($this->lieu_deces_id) && isset($this->lieu_deces_id->lieu_id) ? (int)$this->lieu_deces_id->lieu_id : (is_scalar($this->lieu_deces_id) ? (int)$this->lieu_deces_id : null));
        $adresse_id = is_array($this->adresse_id)
            ? (count($this->adresse_id) ? (int)$this->adresse_id[0] : null)
            : (is_object($this->adresse_id) && isset($this->adresse_id->lieu_id) ? (int)$this->adresse_id->lieu_id : (is_scalar($this->adresse_id) ? (int)$this->adresse_id : null));

        $this->form = [
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'date_naissance' => $this->date_naissance,
            'date_naissance_precision' => $dateNaissancePrecision,
            'lieu_naissance_id' => $lieu_naissance_id,
            'date_deces' => $this->date_deces,
            'date_deces_precision' => $dateDecesPrecision,
            'lieu_deces_id' => $lieu_deces_id,
            'sexe' => $this->sexe,
            'titre' => $this->titre,
            'adresse_id' => $adresse_id,
        ];

        // Validation mutualisée
        $validated = ValidateForm::run($this->form, $this->rules);
        $personne = Personne::create($validated);

        // Synchronisation des relations mutualisée
        SyncRelations::run($personne, [
            'clubs' => $this->clubs,
            'disciplines' => $this->disciplines,
            'sources' => $this->sources,
        ]);

        // Notification mutualisée
        Notify::run('Personne créée avec succès.');
        return redirect()->route('personnes.index');
    }
}
