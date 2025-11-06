<?php

namespace App\Imports;

use App\Models\Personne;
use App\Models\Club;
use App\Imports\BaseImport;
use Maatwebsite\Excel\Concerns\Importable;

class PersonneImport extends BaseImport
{
    use Importable;

    public function model(array $row)
    {
        $data = [
            'nom' => $row['nom'] ?? null,
            'prenom' => $row['prenom'] ?? null,
            'date_naissance' => $row['date_naissance'] ?? null,
            'date_deces' => $row['date_deces'] ?? null,
            'sexe' => $row['sexe'] ?? null,
            'titre' => $row['titre'] ?? null,
        ];
        try {
            // Adresse complète
            if (!empty($row['adresse'])) {
                $lieuFieldsCreate = \App\Models\Lieu::normalizeFields(explode(',', $row['adresse']), false);
                $lieu = \App\Models\Lieu::findNormalized($lieuFieldsCreate);
                if (!$lieu) {
                    $lieu = \App\Models\Lieu::create($lieuFieldsCreate);
                }
                $data['adresse_id'] = $lieu->lieu_id;
            }
            // Lieu de naissance
            if (!empty($row['lieu_naissance'])) {
                $lieuFieldsCreate = \App\Models\Lieu::normalizeFields(explode(',', $row['lieu_naissance']), false);
                $lieuNaissance = \App\Models\Lieu::findNormalized($lieuFieldsCreate);
                if (!$lieuNaissance) {
                    $lieuNaissance = \App\Models\Lieu::create($lieuFieldsCreate);
                }
                $data['lieu_naissance_id'] = $lieuNaissance->lieu_id;
            }
            // Lieu de décès
            if (!empty($row['lieu_deces'])) {
                $lieuFieldsCreate = \App\Models\Lieu::normalizeFields(explode(',', $row['lieu_deces']), false);
                $lieuDeces = \App\Models\Lieu::findNormalized($lieuFieldsCreate);
                if (!$lieuDeces) {
                    $lieuDeces = \App\Models\Lieu::create($lieuFieldsCreate);
                }
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
        } catch (\Exception $e) {
            $this->errors[] = ($row['nom'] ?? '') . ' ' . ($row['prenom'] ?? '');
            return null;
        }
        try {
            // Clubs
            $clubNames = !empty($row['clubs']) ? array_map('trim', explode(',', $row['clubs'])) : [];
            $clubIds = [];
            foreach ($clubNames as $clubName) {
                $club = Club::firstOrCreate(['nom' => $clubName]);
                $clubIds[] = $club->club_id;
            }
            $personne->clubs()->sync($clubIds);
        } catch (\Exception $e) {
            \Log::error('Erreur association personne (clubs) : ' . (($row['nom'] ?? '') . ' ' . ($row['prenom'] ?? '')) . ' - ' . $e->getMessage());
        }
        return $personne;
    }
}
