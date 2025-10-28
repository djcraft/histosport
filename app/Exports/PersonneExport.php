<?php

namespace App\Exports;

use App\Models\Personne;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonneExport implements FromCollection, WithHeadings
{
    protected $personnes;

    public function __construct($personnes = null)
    {
        $this->personnes = $personnes;
    }

    public function collection()
    {
        $personnes = $this->personnes;
        if (!$personnes || $personnes->isEmpty()) {
            $personnes = Personne::with(['clubs'])->get();
        }
        return $personnes->map(function ($personne) {
            $clubs = $personne->clubs->pluck('nom')->implode(', ');
            $adresse = '';
            if ($personne->adresse) {
                $adresse = $personne->adresse->adresse;
                if ($personne->adresse->code_postal) {
                    $adresse .= ', ' . $personne->adresse->code_postal;
                }
                if ($personne->adresse->commune) {
                    $adresse .= ', ' . $personne->adresse->commune;
                }
            }
            $lieu_naissance = '';
            if ($personne->lieu_naissance) {
                $lieu_naissance = $personne->lieu_naissance->adresse;
                if ($personne->lieu_naissance->code_postal) {
                    $lieu_naissance .= ', ' . $personne->lieu_naissance->code_postal;
                }
                if ($personne->lieu_naissance->commune) {
                    $lieu_naissance .= ', ' . $personne->lieu_naissance->commune;
                }
            }
            $lieu_deces = '';
            if ($personne->lieu_deces) {
                $lieu_deces = $personne->lieu_deces->adresse;
                if ($personne->lieu_deces->code_postal) {
                    $lieu_deces .= ', ' . $personne->lieu_deces->code_postal;
                }
                if ($personne->lieu_deces->commune) {
                    $lieu_deces .= ', ' . $personne->lieu_deces->commune;
                }
            }
            return [
                'nom' => $personne->nom,
                'prenom' => $personne->prenom,
                'date_naissance' => $personne->date_naissance,
                'lieu_naissance' => $lieu_naissance,
                'date_deces' => $personne->date_deces,
                'lieu_deces' => $lieu_deces,
                'sexe' => $personne->sexe,
                'titre' => $personne->titre,
                'adresse' => $adresse,
                'clubs' => $clubs,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'nom',
            'prenom',
            'date_naissance',
            'lieu_naissance',
            'date_deces',
            'lieu_deces',
            'sexe',
            'titre',
            'adresse',
            'clubs',
        ];
    }
}
