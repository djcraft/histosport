<?php

namespace App\Imports;

use App\Models\Competition;
use App\Models\Club;
use App\Models\Discipline;
use App\Models\Lieu;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class CompetitionImport implements ToModel, WithHeadingRow
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
                'date' => $row['date'] ?? null,
                'date_precision' => $row['date_precision'] ?? null,
                'type' => $row['type'] ?? null,
                'duree' => $row['duree'] ?? null,
                'niveau' => $row['niveau'] ?? null,
            ];
            // Lieu
            if (!empty($row['lieu'])) {
                $lieuParts = explode(',', $row['lieu']);
                $lieu = Lieu::firstOrCreate([
                    'adresse' => trim($lieuParts[0] ?? ''),
                    'code_postal' => trim($lieuParts[1] ?? ''),
                    'commune' => trim($lieuParts[2] ?? ''),
                ]);
                $data['lieu_id'] = $lieu->lieu_id;
            }
            // Organisateur club
            if (!empty($row['organisateur_club'])) {
                $club = Club::firstOrCreate(['nom' => trim($row['organisateur_club'])]);
                $data['organisateur_club_id'] = $club->club_id;
            }
            // Organisateur personne
            if (!empty($row['organisateur_personne'])) {
                $personneParts = explode(' ', trim($row['organisateur_personne']));
                $prenom = array_shift($personneParts);
                $nom = implode(' ', $personneParts);
                $personne = \App\Models\Personne::firstOrCreate([
                    'prenom' => $prenom,
                    'nom' => $nom,
                ]);
                $data['organisateur_personne_id'] = $personne->personne_id;
            }
            $competition = Competition::where('nom', $data['nom'])->first();
            if ($competition) {
                $competition->update($data);
                $this->updated[] = $data['nom'];
            } else {
                $competition = Competition::create($data);
                $this->created[] = $data['nom'];
            }
            // Disciplines
            if (!empty($row['disciplines'])) {
                $disciplineNames = array_map('trim', explode(',', $row['disciplines']));
                $disciplineIds = [];
                foreach ($disciplineNames as $disciplineName) {
                    $discipline = Discipline::firstOrCreate(['nom' => $disciplineName]);
                    $disciplineIds[] = $discipline->discipline_id;
                }
                $competition->disciplines()->sync($disciplineIds);
            }

            // Clubs et personnes via CompetitionParticipant
            // Clubs
            $clubNames = !empty($row['clubs']) ? array_map('trim', explode(',', $row['clubs'])) : [];
            $clubIds = [];
            foreach ($clubNames as $clubName) {
                $club = Club::firstOrCreate(['nom' => $clubName]);
                $clubIds[] = $club->club_id;
                $exists = \App\Models\CompetitionParticipant::where('competition_id', $competition->competition_id)
                    ->where('club_id', $club->club_id)
                    ->whereNull('personne_id')
                    ->exists();
                if (!$exists) {
                    \App\Models\CompetitionParticipant::create([
                        'competition_id' => $competition->competition_id,
                        'club_id' => $club->club_id,
                    ]);
                }
            }
            // Suppression des clubs absents
            \App\Models\CompetitionParticipant::where('competition_id', $competition->competition_id)
                ->whereNotIn('club_id', $clubIds)
                ->whereNull('personne_id')
                ->delete();

            // Personnes
            $personnesList = !empty($row['personnes']) ? array_map('trim', explode(',', $row['personnes'])) : [];
            $personneIds = [];
            foreach ($personnesList as $personneFullName) {
                $personneParts = explode(' ', $personneFullName);
                $prenom = array_shift($personneParts);
                $nom = implode(' ', $personneParts);
                $personne = \App\Models\Personne::firstOrCreate([
                    'prenom' => $prenom,
                    'nom' => $nom,
                ]);
                $personneIds[] = $personne->personne_id;
                $exists = \App\Models\CompetitionParticipant::where('competition_id', $competition->competition_id)
                    ->where('personne_id', $personne->personne_id)
                    ->whereNull('club_id')
                    ->exists();
                if (!$exists) {
                    \App\Models\CompetitionParticipant::create([
                        'competition_id' => $competition->competition_id,
                        'personne_id' => $personne->personne_id,
                    ]);
                }
            }
            // Suppression des personnes absentes
            \App\Models\CompetitionParticipant::where('competition_id', $competition->competition_id)
                ->whereNotIn('personne_id', $personneIds)
                ->whereNull('club_id')
                ->delete();

            return $competition;
        } catch (\Exception $e) {
            $this->errors[] = $row['nom'] ?? '';
            return null;
        }
    }
}
