<?php

namespace App\Exports;

use App\Models\Club;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClubExport implements FromCollection, WithHeadings
{
    protected $clubs;

    public function __construct($clubs = null)
    {
        $this->clubs = $clubs;
    }

    public function collection()
    {
        $clubs = $this->clubs;
        if (!$clubs || $clubs->isEmpty()) {
            $clubs = Club::with(['disciplines', 'personnes'])->get();
        }
        return $clubs->map(function ($club) {
            $adresse = '';
            if ($club->siege) {
                $adresse = $club->siege->adresse;
                if ($club->siege->code_postal) {
                    $adresse .= ', ' . $club->siege->code_postal;
                }
                if ($club->siege->commune) {
                    $adresse .= ', ' . $club->siege->commune;
                }
            }
            $personnes = $club->personnes->map(function($p) {
                return trim($p->nom . ' ' . $p->prenom);
            })->implode(', ');
            return [
                'nom' => $club->nom,
                'nom_origine' => $club->nom_origine,
                'surnoms' => $club->surnoms,
                'date_fondation' => $club->date_fondation,
                'date_fondation_precision' => $club->date_fondation_precision,
                'date_disparition' => $club->date_disparition,
                'date_disparition_precision' => $club->date_disparition_precision,
                'date_declaration' => $club->date_declaration,
                'date_declaration_precision' => $club->date_declaration_precision,
                'acronyme' => $club->acronyme,
                'couleurs' => $club->couleurs,
                'adresse' => $adresse,
                'notes' => $club->notes,
                'disciplines' => $club->disciplines->pluck('nom')->implode(', '),
                'personnes' => $personnes,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'nom',
            'nom_origine',
            'surnoms',
            'date_fondation',
            'date_fondation_precision',
            'date_disparition',
            'date_disparition_precision',
            'date_declaration',
            'date_declaration_precision',
            'acronyme',
            'couleurs',
            'adresse',
            'notes',
            'disciplines',
            'personnes',
        ];
    }
}
