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
        return [
            'nom' => $lieu->nom ?? '',
            'adresse' => $lieu->adresse ?? '',
            'commune' => $lieu->commune ?? '',
            'code_postal' => $lieu->code_postal ?? '',
            'departement' => $lieu->departement ?? '',
            'pays' => $lieu->pays ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            'nom',
            'adresse',
            'commune',
            'code_postal',
            'departement',
            'pays',
        ];
    }
}
