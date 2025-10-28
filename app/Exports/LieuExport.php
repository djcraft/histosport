<?php

namespace App\Exports;

use App\Models\Lieu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LieuExport implements FromCollection, WithHeadings
{
    protected $ids;

    public function __construct($ids = null)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        $lieux = Lieu::query();
        if ($this->ids) {
            $lieux = $lieux->whereIn('lieu_id', $this->ids);
        }
        $lieux = $lieux->get();
        return $lieux->map(function ($lieu) {
            return [
                'adresse' => $lieu->adresse,
                'code_postal' => $lieu->code_postal,
                'commune' => $lieu->commune,
                'departement' => $lieu->departement,
                'pays' => $lieu->pays,
            ];
        });
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
