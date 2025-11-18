<?php

namespace App\Imports;

use App\Models\Lieu;
use App\Imports\BaseImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;

class LieuImport extends BaseImport
{
    use Importable;

    public function model(array $row)
    {
        $data = [
            'nom' => $row['nom'] ?? null,
            'adresse' => $row['adresse'] ?? null,
            'commune' => $row['commune'] ?? null,
            'code_postal' => $row['code_postal'] ?? null,
            'departement' => $row['departement'] ?? null,
            'pays' => $row['pays'] ?? null,
        ];
        try {
            $lieuFieldsCreate = Lieu::normalizeFields([
                $row['nom'] ?? null,
                $row['adresse'] ?? null,
                $row['commune'] ?? null,
                $row['code_postal'] ?? null,
                $row['departement'] ?? null,
                $row['pays'] ?? null,
            ], false);
            $lieu = Lieu::findNormalized($lieuFieldsCreate);
            if ($lieu) {
                $lieu->update($lieuFieldsCreate);
                $this->updated[] = $lieuFieldsCreate['nom'] ?? $lieuFieldsCreate['adresse'];
            } else {
                $lieu = Lieu::create($lieuFieldsCreate);
                $this->created[] = $lieuFieldsCreate['nom'] ?? $lieuFieldsCreate['adresse'];
            }
        } catch (\Exception $e) {
            $this->errors[] = $row['adresse'] ?? '';
            return null;
        }
        try {
            // Synchronisation des liens (sources, clubs, personnes, compétitions)
            // Sources
            $sourceIds = [];
            if (!empty($row['sources'])) {
                $sourceTitles = array_map('trim', explode(',', $row['sources']));
                foreach ($sourceTitles as $titre) {
                    $source = \App\Models\Source::where('titre', $titre)->first();
                    if ($source) {
                        $sourceIds[] = $source->source_id;
                    }
                }
            }
            $lieu->sources()->sync($sourceIds);

            // Clubs
            $clubIds = [];
            if (!empty($row['clubs'])) {
                $clubNames = array_map('trim', explode(',', $row['clubs']));
                foreach ($clubNames as $nom) {
                    $club = \App\Models\Club::where('nom', $nom)->first();
                    if ($club) {
                        $clubIds[] = $club->club_id;
                    }
                }
            }
            $lieu->clubs()->sync($clubIds);

            // Compétitions
            $competitionIds = [];
            if (!empty($row['competitions'])) {
                $competitionNames = array_map('trim', explode(',', $row['competitions']));
                foreach ($competitionNames as $nom) {
                    $competition = \App\Models\Competition::where('nom', $nom)->first();
                    if ($competition) {
                        $competitionIds[] = $competition->competition_id;
                    }
                }
            }
            $lieu->competitions()->sync($competitionIds);
        } catch (\Exception $e) {
            Log::error('Erreur association lieu (sources/clubs/personnes/compétitions) : ' . ($row['adresse'] ?? '') . ' - ' . $e->getMessage());
        }
        return $lieu;
    }
}
