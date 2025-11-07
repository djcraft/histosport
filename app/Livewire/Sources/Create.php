<?php

namespace App\Livewire\Sources;

use App\Livewire\BaseCrudComponent;
use App\Livewire\Actions\Notify;

class Create extends BaseCrudComponent
{
    public $titre;
    public $auteur;
    public $annee_reference;
    public $type;
    public $cote;
    public $url;
    public $lieu_edition_id;
    public $lieu_conservation_id;
    public $lieu_couverture_id;
    protected function rules()
    {
        return \App\Rules\SourceRules::rules();
    }

    protected $listeners = [
        'lieuCreated' => 'onLieuCreated',
    ];

    public function onLieuCreated($id)
    {
        $this->lieu_edition_id = $id;
    }

    public function save()
    {
        if (is_array($this->lieu_edition_id)) {
            $this->lieu_edition_id = count($this->lieu_edition_id) ? intval($this->lieu_edition_id[0]) : null;
        } else {
            $this->lieu_edition_id = is_numeric($this->lieu_edition_id) ? intval($this->lieu_edition_id) : null;
        }
        if (is_array($this->lieu_conservation_id)) {
            $this->lieu_conservation_id = count($this->lieu_conservation_id) ? intval($this->lieu_conservation_id[0]) : null;
        } else {
            $this->lieu_conservation_id = is_numeric($this->lieu_conservation_id) ? intval($this->lieu_conservation_id) : null;
        }
        if (is_array($this->lieu_couverture_id)) {
            $this->lieu_couverture_id = count($this->lieu_couverture_id) ? intval($this->lieu_couverture_id[0]) : null;
        } else {
            $this->lieu_couverture_id = is_numeric($this->lieu_couverture_id) ? intval($this->lieu_couverture_id) : null;
        }
        $this->validate($this->rules);

        // Détection automatique de la précision de l'année de référence
        $anneeReferencePrecision = null;
        if (preg_match('/^\d{4}$/', $this->annee_reference)) {
            $anneeReferencePrecision = 'year';
        } elseif (preg_match('/^\d{4}-\d{2}$/', $this->annee_reference)) {
            $anneeReferencePrecision = 'month';
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->annee_reference)) {
            $anneeReferencePrecision = 'day';
        }

        \App\Models\Source::create([
            'titre' => $this->titre,
            'auteur' => $this->auteur,
            'annee_reference' => $this->annee_reference,
            'annee_reference_precision' => $anneeReferencePrecision,
            'type' => $this->type,
            'cote' => $this->cote,
            'url' => $this->url,
            'lieu_edition_id' => $this->lieu_edition_id,
            'lieu_conservation_id' => $this->lieu_conservation_id,
            'lieu_couverture_id' => $this->lieu_couverture_id,
        ]);

        Notify::run('Source créée avec succès.');
        return redirect()->route('sources.index');
    }

    public function render()
    {
        $lieux = \App\Models\Lieu::all();
        $allLieux = \App\Models\Lieu::all();
        $allPersonnes = \App\Models\Personne::all();
        $allDisciplines = \App\Models\Discipline::all();
        $allCompetitions = \App\Models\Competition::all();
        return view('livewire.sources.create', compact('lieux', 'allLieux', 'allPersonnes', 'allDisciplines', 'allCompetitions'));
    }
}
