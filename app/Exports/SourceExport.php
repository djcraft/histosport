<?php

namespace App\Exports;

use App\Models\Source;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SourceExport implements FromCollection, WithHeadings
{
    protected $ids;

    public function __construct($ids = null)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        $sources = Source::query();
        if ($this->ids) {
            $sources = $sources->whereIn('source_id', $this->ids);
        }
        $sources = $sources->get();
        return $sources->map(function ($source) {
            return [
                'titre' => $source->titre,
                'auteur' => $source->auteur,
                'annee_reference' => $source->annee_reference,
                'type' => $source->type,
                'cote' => $source->cote,
                'lieu_edition' => $source->lieuEdition ? ($source->lieuEdition->adresse . ', ' . $source->lieuEdition->code_postal . ', ' . $source->lieuEdition->commune) : '',
                'lieu_conservation' => $source->lieuConservation ? ($source->lieuConservation->adresse . ', ' . $source->lieuConservation->code_postal . ', ' . $source->lieuConservation->commune) : '',
                'lieu_couverture' => $source->lieuCouverture ? ($source->lieuCouverture->adresse . ', ' . $source->lieuCouverture->code_postal . ', ' . $source->lieuCouverture->commune) : '',
                'url' => $source->url,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'titre',
            'auteur',
            'annee_reference',
            'type',
            'cote',
            'lieu_edition',
            'lieu_conservation',
            'lieu_couverture',
            'url',
        ];
    }
}
