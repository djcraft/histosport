<?php


namespace App\Exports;

use App\Models\Discipline;

class DisciplineExport extends BaseExport
{
    protected function getEntities()
    {
        $query = Discipline::query();
        if ($this->ids) {
            $query = $query->whereIn('discipline_id', $this->ids);
        }
        return $query->get();
    }

    protected function getModelClass()
    {
        return Discipline::class;
    }

    protected function getPrimaryKey()
    {
        return 'discipline_id';
    }

    protected function transform($discipline)
    {
        return [
            'nom' => $discipline->nom,
            'description' => $discipline->description,
        ];
    }

    public function headings(): array
    {
        return [
            'nom',
            'description',
        ];
    }
}
