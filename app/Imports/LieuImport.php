<?php

namespace App\Imports;

use App\Models\Lieu;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class LieuImport implements ToModel, WithHeadingRow
{
    use Importable;

    public $created = [];
    public $updated = [];
    public $errors = [];

    public function model(array $row)
    {
        try {
            $data = [
                'adresse' => $row['adresse'] ?? null,
                'code_postal' => $row['code_postal'] ?? null,
                'commune' => $row['commune'] ?? null,
            ];
            $lieu = Lieu::where('adresse', $data['adresse'])
                ->where('code_postal', $data['code_postal'])
                ->where('commune', $data['commune'])
                ->first();
            if ($lieu) {
                $lieu->update($data);
                $this->updated[] = $data['adresse'];
            } else {
                $lieu = Lieu::create($data);
                $this->created[] = $data['adresse'];
            }
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

            // Personnes
            $personneIds = [];
            if (!empty($row['personnes'])) {
                $personnesList = array_map('trim', explode(',', $row['personnes']));
                foreach ($personnesList as $personneFullName) {
                    $personneParts = explode(' ', $personneFullName);
                    $prenom = array_shift($personneParts);
                    $nom = implode(' ', $personneParts);
                    $personne = \App\Models\Personne::where('prenom', $prenom)->where('nom', $nom)->first();
                    if ($personne) {
                        $personneIds[] = $personne->personne_id;
                    }
                }
            }
            $lieu->personnes()->sync($personneIds);

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

            return $lieu;
        } catch (\Exception $e) {
            $this->errors[] = $row['adresse'] ?? '';
            return null;
        }
    }
}
