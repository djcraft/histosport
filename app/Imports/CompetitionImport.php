<?php

namespace App\Imports;

use App\Models\Competition;
use App\Models\Club;
use App\Models\Discipline;
use App\Models\Lieu;
use App\Imports\BaseImport;
use Maatwebsite\Excel\Concerns\Importable;

class CompetitionImport extends BaseImport
{
    use Importable;

    public function model(array $row)
    {
        // ...existing code...
        $data = [
            'nom' => $row['nom'] ?? null,
            'date' => $row['date'] ?? null,
            'date_precision' => $row['date_precision'] ?? null,
            'type' => $row['type'] ?? null,
            'duree' => $row['duree'] ?? null,
            'niveau' => $row['niveau'] ?? null,
        ];
        try {
            // Lieu principal
            if (!empty($row['lieu'])) {
                $lieuFieldsCreate = Lieu::normalizeFields(explode(',', $row['lieu']), false);
                $lieu = Lieu::findNormalized($lieuFieldsCreate);
                if (!$lieu) {
                    $lieu = Lieu::create($lieuFieldsCreate);
                }
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
        } catch (\Exception $e) {
            $this->errors[] = $row['nom'] ?? '';
            return null;
        }
        try {
            // Association des sites (lieux multiples)
            if (!empty($row['sites'])) {
                $siteStrs = array_map('trim', explode(';', $row['sites']));
                $siteIds = [];
                foreach ($siteStrs as $siteStr) {
                    $lieuFieldsCreate = Lieu::normalizeFields(explode(',', $siteStr), false);
                    $lieu = Lieu::findNormalized($lieuFieldsCreate);
                    if (!$lieu) {
                        $lieu = Lieu::create($lieuFieldsCreate);
                    }
                    $siteIds[] = $lieu->lieu_id;
                }
                $competition->sites()->sync($siteIds);
            }
        } catch (\Exception $e) {
            \Log::error('Erreur association compétition (sites) : ' . ($row['nom'] ?? '') . ' - ' . $e->getMessage());
        }
        try {
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

            // Clubs et personnes avec résultats
            // Clubs
            $clubResults = !empty($row['resultats_clubs']) ? array_map('trim', explode('|', $row['resultats_clubs'])) : [];
            $clubIds = [];
            foreach ($clubResults as $clubResult) {
                [$clubName, $resultat] = array_map('trim', explode(':', $clubResult, 2));
                $club = Club::firstOrCreate(['nom' => $clubName]);
                $clubIds[] = $club->club_id;
                $participant = \App\Models\CompetitionParticipant::where('competition_id', $competition->competition_id)
                    ->where('club_id', $club->club_id)
                    ->whereNull('personne_id')
                    ->first();
                if ($participant) {
                    $participant->update(['resultat' => $resultat]);
                } else {
                    \App\Models\CompetitionParticipant::create([
                        'competition_id' => $competition->competition_id,
                        'club_id' => $club->club_id,
                        'resultat' => $resultat,
                    ]);
                }
            }
            // Suppression des clubs absents
            \App\Models\CompetitionParticipant::where('competition_id', $competition->competition_id)
                ->whereNotIn('club_id', $clubIds)
                ->whereNull('personne_id')
                ->delete();

            // Personnes
            $personneResults = !empty($row['resultats_personnes']) ? array_map('trim', explode('|', $row['resultats_personnes'])) : [];
            $personneIds = [];
            foreach ($personneResults as $personneResult) {
                [$personneFullName, $resultat] = array_map('trim', explode(':', $personneResult, 2));
                $personneParts = explode(' ', $personneFullName);
                $prenom = array_shift($personneParts);
                $nom = implode(' ', $personneParts);
                $personne = \App\Models\Personne::firstOrCreate([
                    'prenom' => $prenom,
                    'nom' => $nom,
                ]);
                $personneIds[] = $personne->personne_id;
                $participant = \App\Models\CompetitionParticipant::where('competition_id', $competition->competition_id)
                    ->where('personne_id', $personne->personne_id)
                    ->whereNull('club_id')
                    ->first();
                if ($participant) {
                    $participant->update(['resultat' => $resultat]);
                } else {
                    \App\Models\CompetitionParticipant::create([
                        'competition_id' => $competition->competition_id,
                        'personne_id' => $personne->personne_id,
                        'resultat' => $resultat,
                    ]);
                }
            }
            // Suppression des personnes absentes
            \App\Models\CompetitionParticipant::where('competition_id', $competition->competition_id)
                ->whereNotIn('personne_id', $personneIds)
                ->whereNull('club_id')
                ->delete();

            // Association des sites (lieux multiples) avec formatage
            if (!empty($row['sites'])) {
                $siteStrs = array_map('trim', explode(';', $row['sites']));
                $siteIds = [];
                foreach ($siteStrs as $siteStr) {
                    $lieuFieldsCreate = Lieu::normalizeFields(explode(',', $siteStr), false);
                    $lieu = Lieu::findNormalized($lieuFieldsCreate);
                    if (!$lieu) {
                        $lieu = Lieu::create($lieuFieldsCreate);
                    }
                    $siteIds[] = $lieu->lieu_id;
                }
                $competition->sites()->sync($siteIds);
            }
        } catch (\Exception $e) {
            \Log::error('Erreur association compétition (disciplines/clubs/personnes/sites) : ' . ($row['nom'] ?? '') . ' - ' . $e->getMessage());
        }
        return $competition;
    }
}
