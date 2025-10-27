<?php

namespace App\Livewire\Sources;

use Livewire\Component;

class Create extends Component
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

    public function save()
    {
        $this->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'nullable|string|max:255',
            'annee_reference' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'cote' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'lieu_edition_id' => 'nullable|integer|exists:lieu,lieu_id',
            'lieu_conservation_id' => 'nullable|integer|exists:lieu,lieu_id',
            'lieu_couverture_id' => 'nullable|integer|exists:lieu,lieu_id',
        ]);

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

        session()->flash('success', 'Source créée avec succès.');
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
