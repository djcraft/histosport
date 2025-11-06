<?php
namespace App\Livewire\Sources;

use App\Livewire\BaseCrudComponent;

class Edit extends BaseCrudComponent
{
    public $source;
    public $titre;
    public $auteur;
    public $annee_reference;
    public $type;
    public $cote;
    public $url;
    public $lieu_edition_id;
    public $lieu_conservation_id;
    public $lieu_couverture_id;

    protected $rules = [
        'titre' => 'required|string|max:255',
        'auteur' => 'nullable|string|max:255',
        'annee_reference' => 'nullable|string|max:255',
        'type' => 'nullable|string|max:255',
        'cote' => 'nullable|string|max:255',
        'url' => 'nullable|string|max:255',
        'lieu_edition_id' => 'nullable|integer|exists:lieu,lieu_id',
        'lieu_conservation_id' => 'nullable|integer|exists:lieu,lieu_id',
        'lieu_couverture_id' => 'nullable|integer|exists:lieu,lieu_id',
    ];

    protected $listeners = [
        'lieuCreated' => 'onLieuCreated',
    ];

    public function onLieuCreated($id)
    {
        $this->lieu_edition_id = $id;
    }

    public function update()
    {
        // Conversion si tableau (mono-select)
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

        $this->source->update([
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

        session()->flash('success', 'Source mise à jour avec succès.');
        return redirect()->route('sources.index');
    }

    public function mount(\App\Models\Source $source)
    {
        $this->source = $source;
        $this->titre = $source->titre;
        $this->auteur = $source->auteur;
        $this->annee_reference = $source->annee_reference;
        $this->type = $source->type;
        $this->cote = $source->cote;
        $this->url = $source->url;
        $this->lieu_edition_id = is_array($source->lieu_edition_id) ? (count($source->lieu_edition_id) ? intval($source->lieu_edition_id[0]) : null) : $source->lieu_edition_id;
        $this->lieu_conservation_id = is_array($source->lieu_conservation_id) ? (count($source->lieu_conservation_id) ? intval($source->lieu_conservation_id[0]) : null) : $source->lieu_conservation_id;
        $this->lieu_couverture_id = is_array($source->lieu_couverture_id) ? (count($source->lieu_couverture_id) ? intval($source->lieu_couverture_id[0]) : null) : $source->lieu_couverture_id;
    }

    public function render()
    {
        $lieux = \App\Models\Lieu::all();
        $allLieux = \App\Models\Lieu::all();
        $allClubs = \App\Models\Club::all();
        $allPersonnes = \App\Models\Personne::all();
        $allDisciplines = \App\Models\Discipline::all();
        $allCompetitions = \App\Models\Competition::all();
        return view('livewire.sources.edit', compact('lieux', 'allLieux', 'allClubs', 'allPersonnes', 'allDisciplines', 'allCompetitions'));
    }
}
