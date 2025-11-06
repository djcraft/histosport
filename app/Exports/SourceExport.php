<?php


namespace App\Exports;

use App\Models\Source;

class SourceExport extends BaseExport
{
    protected function getEntities()
    {
        $query = Source::with(['lieuEdition', 'lieuConservation', 'lieuCouverture']);
        if ($this->ids) {
            $query = $query->whereIn('source_id', $this->ids);
        }
        return $query->get();
    }

    protected function getModelClass()
    {
        return Source::class;
    }

    protected function getPrimaryKey()
    {
        return 'source_id';
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

    protected function transform($source)
    {
        return [
            'titre' => $source->titre,
            'auteur' => $source->auteur,
            'annee_reference' => $source->annee_reference,
            'type' => $source->type,
            'cote' => $source->cote,
            'lieu_edition' => $this->formatLieu($source->lieuEdition),
            'lieu_conservation' => $this->formatLieu($source->lieuConservation),
            'lieu_couverture' => $this->formatLieu($source->lieuCouverture),
            'url' => $source->url,
        ];
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
