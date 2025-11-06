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

    protected function transform($lieu)
    {
        return [
            'adresse' => $lieu->adresse,
            'code_postal' => $lieu->code_postal,
            'commune' => $lieu->commune,
            'departement' => $lieu->departement,
            'pays' => $lieu->pays,
        ];
    }

    public function headings(): array
    {
        return [
            'adresse',
            'code_postal',
            'commune',
            'departement',
            'pays',
        ];
    }
}
