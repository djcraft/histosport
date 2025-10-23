<?php

namespace App\Livewire\Sources;

use Livewire\Component;

class Edit extends Component
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

    public function update()
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

        $this->source->update([
            'titre' => $this->titre,
            'auteur' => $this->auteur,
            'annee_reference' => $this->annee_reference,
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
        $this->lieu_edition_id = $source->lieu_edition_id;
        $this->lieu_conservation_id = $source->lieu_conservation_id;
        $this->lieu_couverture_id = $source->lieu_couverture_id;
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
