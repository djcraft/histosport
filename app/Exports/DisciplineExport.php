<?php

namespace App\Exports;

use App\Models\Discipline;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DisciplineExport implements FromCollection, WithHeadings
{
    protected $ids;

    public function __construct($ids = null)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        $disciplines = Discipline::with('clubs');
        if ($this->ids) {
            $disciplines = $disciplines->whereIn('discipline_id', $this->ids);
        }
        $disciplines = $disciplines->get();
        return $disciplines->map(function ($discipline) {
            $clubs = $discipline->clubs->pluck('nom')->implode(', ');
            return [
                'nom' => $discipline->nom,
                'description' => $discipline->description,
                'clubs' => $clubs,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'nom',
            'description',
            'clubs',
        ];
    }
}
