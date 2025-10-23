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
        $this->lieux = Lieu::all();
        $this->adresses = Lieu::all();
        $this->allClubs = Club::all();
        $this->allDisciplines = \App\Models\Discipline::all();
    }

    public function render()
    {
        return view('livewire.personnes.edit', [
            'lieux' => $this->lieux,
            'adresses' => $this->adresses,
            'allClubs' => $this->allClubs,
            'disciplines' => $this->allDisciplines,
        ]);
    }

    public function update()
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

        $this->personne->update([
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
        $this->personne->clubs()->sync($this->clubs);

        // Disciplines (many-to-many)
        $this->personne->disciplines()->sync($this->disciplines);

        session()->flash('success', 'Personne modifiée avec succès.');
        return redirect()->route('personnes.index');
    }
}
