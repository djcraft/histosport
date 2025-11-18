<?php

namespace App\Imports;

use App\Models\Source;
use App\Models\Lieu;
use App\Imports\BaseImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;

class SourceImport extends BaseImport
{
    use Importable;

    public function model(array $row)
    {
            $data = [
                'titre' => $row['titre'] ?? '',
                'auteur' => $row['auteur'] ?? '',
                'annee_reference' => $row['annee_reference'] ?? '',
                'type' => $row['type'] ?? '',
                'cote' => $row['cote'] ?? '',
                'url' => $row['url'] ?? '',
            ];
        try {
            // Lieux liés
            if (!empty($row['lieu_edition'])) {
                $lieuFieldsCreate = Lieu::normalizeFields(explode(',', $row['lieu_edition']), false);
                $lieuEdition = Lieu::findNormalized($lieuFieldsCreate);
                if (!$lieuEdition) {
                    $lieuEdition = Lieu::create($lieuFieldsCreate);
                }
                $data['lieu_edition_id'] = $lieuEdition->lieu_id;
            }
            if (!empty($row['lieu_conservation'])) {
                $lieuFieldsCreate = Lieu::normalizeFields(explode(',', $row['lieu_conservation']), false);
                $lieuConservation = Lieu::findNormalized($lieuFieldsCreate);
                if (!$lieuConservation) {
                    $lieuConservation = Lieu::create($lieuFieldsCreate);
                }
                $data['lieu_conservation_id'] = $lieuConservation->lieu_id;
            }
            if (!empty($row['lieu_couverture'])) {
                $lieuFieldsCreate = Lieu::normalizeFields(explode(',', $row['lieu_couverture']), false);
                $lieuCouverture = Lieu::findNormalized($lieuFieldsCreate);
                if (!$lieuCouverture) {
                    $lieuCouverture = Lieu::create($lieuFieldsCreate);
                }
                $data['lieu_couverture_id'] = $lieuCouverture->lieu_id;
            }
            $fieldsNormalized = Source::normalizeFields($data);
            $source = Source::findNormalized($fieldsNormalized);
            if ($source) {
                $source->update($data);
                $this->updated[] = $data['titre'];
            } else {
                $source = Source::create($data);
                $this->created[] = $data['titre'];
            }
            // Synchronisation des lieux liés (édition, conservation, couverture)
            // Suppression des liens absents
            foreach ([
                'lieu_edition_id' => 'lieu_edition',
                'lieu_conservation_id' => 'lieu_conservation',
                'lieu_couverture_id' => 'lieu_couverture',
            ] as $field => $col) {
                if (empty($row[$col])) {
                    $source->$field = null;
                }
            }
            $source->save();
        } catch (\Exception $e) {
            $this->errors[] = $row['titre'] ?? '';
            Log::error('Erreur import source : ' . ($row['titre'] ?? '') . ' - ' . $e->getMessage());
            return null;
        }
        try {
            // Synchronisation des entités liées (entity_source)
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
            $source->clubs()->sync($clubIds);

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
            $source->personnes()->sync($personneIds);

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
            $source->competitions()->sync($competitionIds);

            // Lieux
            $lieuIds = [];
            if (!empty($row['lieux'])) {
                $lieuNames = array_map('trim', explode(',', $row['lieux']));
                foreach ($lieuNames as $lieuNom) {
                    $lieu = \App\Models\Lieu::where('adresse', $lieuNom)->first();
                    if ($lieu) {
                        $lieuIds[] = $lieu->lieu_id;
                    }
                }
            }
            $source->lieux()->sync($lieuIds);
        } catch (\Exception $e) {
            Log::error('Erreur association source (clubs/personnes/compétitions/lieux) : ' . ($row['titre'] ?? '') . ' - ' . $e->getMessage());
        }
        return $source;
    }
}
