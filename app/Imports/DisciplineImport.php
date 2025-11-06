<?php

namespace App\Imports;

use App\Models\Discipline;
use App\Models\Club;
use App\Imports\BaseImport;
use Maatwebsite\Excel\Concerns\Importable;

class DisciplineImport extends BaseImport
{
    use Importable;

    public function model(array $row)
    {
        $data = [
            'nom' => $row['nom'] ?? null,
            'description' => $row['description'] ?? null,
        ];
        try {
            $discipline = Discipline::where('nom', $data['nom'])->first();
            if ($discipline) {
                $discipline->update($data);
                $this->updated[] = $data['nom'];
            } else {
                $discipline = Discipline::create($data);
                $this->created[] = $data['nom'];
            }
        } catch (\Exception $e) {
            $this->errors[] = $row['nom'] ?? '';
            return null;
        }
        return $discipline;
    }
}
