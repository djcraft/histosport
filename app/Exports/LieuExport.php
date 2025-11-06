<?php


namespace App\Exports;

use App\Models\Lieu;

class LieuExport extends BaseExport
{
    protected function getModelClass()
    {
        return Lieu::class;
    }

    protected function getPrimaryKey()
    {
        return 'lieu_id';
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

    protected function transform($lieu)
    {
        $adresse = $this->formatLieu($lieu);
        return [
            'adresse' => $adresse,
        ];
    }

    public function headings(): array
    {
        return [
            'adresse',
        ];
    }
}
