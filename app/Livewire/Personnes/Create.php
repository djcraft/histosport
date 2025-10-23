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

    public function mount()
    {
        $this->lieux = Lieu::all();
        $this->adresses = Lieu::all();
        $this->allClubs = Club::all();
        $this->allDisciplines = \App\Models\Discipline::all();
    }

    public function render()
    {
        return view('livewire.personnes.create', [
            'lieux' => $this->lieux,
            'adresses' => $this->adresses,
            'allClubs' => $this->allClubs,
            'disciplines' => $this->allDisciplines,
        ]);
    }

    public function save()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date',
            'lieu_naissance_id' => 'nullable|exists:lieu,lieu_id',
            'date_deces' => 'nullable|date',
            'lieu_deces_id' => 'nullable|exists:lieu,lieu_id',
            'sexe' => 'nullable|string|max:10',
            'titre' => 'nullable|string|max:100',
            'adresse_id' => 'nullable|exists:lieu,lieu_id',
        ]);

        $personne = Personne::create([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'date_naissance' => $this->date_naissance,
            'lieu_naissance_id' => $this->lieu_naissance_id,
            'date_deces' => $this->date_deces,
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

        session()->flash('success', 'Personne créée avec succès.');
        return redirect()->route('personnes.index');
    }
}
