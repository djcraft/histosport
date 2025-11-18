<?php

namespace App\Imports;

use App\Models\Discipline;
use App\Models\Club;
use App\Imports\BaseImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;

class DisciplineImport extends BaseImport
{
    use Importable;

    public function model(array $row)
    {
            $data = [
                'nom' => $row['nom'] ?? '',
                'description' => $row['description'] ?? '',
            ];
            try {
                $fieldsNormalized = Discipline::normalizeFields($data);
                $discipline = Discipline::findNormalized($fieldsNormalized);
                if ($discipline) {
                    $discipline->update($data);
                    $this->updated[] = $data['nom'];
                } else {
                    $discipline = Discipline::create($data);
                    $this->created[] = $data['nom'];
                }
            } catch (\Exception $e) {
                $this->errors[] = $row['nom'] ?? '';
                Log::error('Erreur import discipline : ' . ($row['nom'] ?? '') . ' - ' . $e->getMessage());
                return null;
            }
            return $discipline;
    }
}
