<?php


namespace App\Exports;

use App\Models\Club;

class ClubExport extends BaseExport
{

    protected function getEntities()
    {
        $query = Club::with(['siege', 'personnes', 'disciplines']);
        if ($this->ids) {
            $query = $query->whereIn('club_id', $this->ids);
        }
        return $query->get();
    }

    protected function getModelClass()
    {
        return Club::class;
    }

    protected function getPrimaryKey()
    {
        return 'club_id';
    }

    protected function formatLieu($lieu)
    {
        if (!$lieu) return ', , , , , ';
        $fields = [
            $lieu->nom ?? '',
            $lieu->adresse ?? '',
            $lieu->commune ?? '',
            $lieu->code_postal ?? '',
            $lieu->departement ?? '',
            $lieu->pays ?? ''
        ];
        return implode(', ', $fields);
    }

    protected function transform($club)
    {
        $siege = $this->formatLieu($club->siege);
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
            'siege' => $siege,
            'notes' => $club->notes,
            'disciplines' => $this->formatListe($club->disciplines),
            'personnes' => $personnes,
        ];
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
            'siege',
            'notes',
            'disciplines',
            'personnes',
        ];
    }
}
