<?php

namespace App\Livewire\Personnes;

use Livewire\Component;

use App\Models\Personne;
use App\Models\Club;
use App\Models\Lieu;

class Edit extends Component
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

        $lieuNaissanceId = is_array($this->lieu_naissance_id)
            ? (count($this->lieu_naissance_id) ? $this->lieu_naissance_id[0] : null)
            : $this->lieu_naissance_id;
        $lieuDecesId = is_array($this->lieu_deces_id)
            ? (count($this->lieu_deces_id) ? $this->lieu_deces_id[0] : null)
            : $this->lieu_deces_id;
        $adresseId = is_array($this->adresse_id)
            ? (count($this->adresse_id) ? $this->adresse_id[0] : null)
            : $this->adresse_id;
        $this->personne->update([
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
        ]);

        // Clubs (many-to-many)
        $this->personne->clubs()->sync($this->clubs);

        // Disciplines (many-to-many)
        $this->personne->disciplines()->sync($this->disciplines);

        // Sources (many-to-many polymorphique)
        $this->personne->sources()->syncWithPivotValues(
            array_map('intval', (array) $this->sources),
            ['entity_type' => 'personne']
        );

    session()->flash('success', 'Personne modifiée avec succès.');
    return redirect()->route('personnes.index');
    }
}
