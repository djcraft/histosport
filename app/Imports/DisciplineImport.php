<?php

namespace App\Imports;

use App\Models\Discipline;
use App\Models\Club;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class DisciplineImport implements ToModel, WithHeadingRow
{
    use Importable;

    public $created = [];
    public $updated = [];
    public $errors = [];

    public function model(array $row)
    {
        try {
            $data = [
                'nom' => $row['nom'] ?? null,
                'description' => $row['description'] ?? null,
            ];
            $discipline = Discipline::where('nom', $data['nom'])->first();
            if ($discipline) {
                $discipline->update($data);
                $this->updated[] = $data['nom'];
            } else {
                $discipline = Discipline::create($data);
                $this->created[] = $data['nom'];
            }
            // Clubs
            $clubNames = !empty($row['clubs']) ? array_map('trim', explode(',', $row['clubs'])) : [];
            $clubIds = [];
            foreach ($clubNames as $clubName) {
                $club = Club::firstOrCreate(['nom' => $clubName]);
                $clubIds[] = $club->club_id;
            }
            $discipline->clubs()->sync($clubIds);
            return $discipline;
        } catch (\Exception $e) {
            $this->errors[] = $row['nom'] ?? '';
            return null;
        }
    }
}
