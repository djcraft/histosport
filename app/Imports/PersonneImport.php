<?php

namespace App\Imports;

use App\Models\Personne;
use App\Models\Club;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class PersonneImport implements ToModel, WithHeadingRow
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
                'prenom' => $row['prenom'] ?? null,
                'date_naissance' => $row['date_naissance'] ?? null,
                'date_deces' => $row['date_deces'] ?? null,
                'sexe' => $row['sexe'] ?? null,
                'titre' => $row['titre'] ?? null,
            ];
            // Adresse complète
            if (!empty($row['adresse'])) {
                $adresseParts = array_map('trim', explode(',', $row['adresse']));
                $lieu = \App\Models\Lieu::firstOrCreate([
                    'adresse' => $adresseParts[0] ?? '',
                    'code_postal' => $adresseParts[1] ?? '',
                    'commune' => $adresseParts[2] ?? '',
                ]);
                $data['adresse_id'] = $lieu->lieu_id;
            }
            // Lieu de naissance
            if (!empty($row['lieu_naissance'])) {
                $naissanceParts = explode(',', $row['lieu_naissance']);
                $lieuNaissance = \App\Models\Lieu::firstOrCreate([
                    'adresse' => trim($naissanceParts[0] ?? ''),
                    'code_postal' => trim($naissanceParts[1] ?? ''),
                    'commune' => trim($naissanceParts[2] ?? ''),
                ]);
                $data['lieu_naissance_id'] = $lieuNaissance->lieu_id;
            }
            // Lieu de décès
            if (!empty($row['lieu_deces'])) {
                $decesParts = explode(',', $row['lieu_deces']);
                $lieuDeces = \App\Models\Lieu::firstOrCreate([
                    'adresse' => trim($decesParts[0] ?? ''),
                    'code_postal' => trim($decesParts[1] ?? ''),
                    'commune' => trim($decesParts[2] ?? ''),
                ]);
                $data['lieu_deces_id'] = $lieuDeces->lieu_id;
            }
            $personne = Personne::where('nom', $data['nom'])->where('prenom', $data['prenom'])->first();
            if ($personne) {
                $personne->update($data);
                $this->updated[] = $data['nom'] . ' ' . $data['prenom'];
            } else {
                $personne = Personne::create($data);
                $this->created[] = $data['nom'] . ' ' . $data['prenom'];
            }
            // Clubs
            $clubNames = !empty($row['clubs']) ? array_map('trim', explode(',', $row['clubs'])) : [];
            $clubIds = [];
            foreach ($clubNames as $clubName) {
                $club = Club::firstOrCreate(['nom' => $clubName]);
                $clubIds[] = $club->club_id;
            }
            $personne->clubs()->sync($clubIds);
            return $personne;
        } catch (\Exception $e) {
            $this->errors[] = ($row['nom'] ?? '') . ' ' . ($row['prenom'] ?? '');
            return null;
        }
    }
}
