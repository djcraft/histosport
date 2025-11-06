<?php

namespace App\Imports;

use App\Models\Club;
use App\Imports\BaseImport;
use Maatwebsite\Excel\Concerns\Importable;

class ClubImport extends BaseImport
{
    use Importable;

    public function model(array $row)
    {
        $data = [
            'nom' => $row['nom'] ?? null,
            'nom_origine' => $row['nom_origine'] ?? null,
            'surnoms' => $row['surnoms'] ?? null,
            'date_fondation' => $row['date_fondation'] ?? null,
            'date_fondation_precision' => $row['date_fondation_precision'] ?? null,
            'date_disparition' => $row['date_disparition'] ?? null,
            'date_disparition_precision' => $row['date_disparition_precision'] ?? null,
            'date_declaration' => $row['date_declaration'] ?? null,
            'date_declaration_precision' => $row['date_declaration_precision'] ?? null,
            'acronyme' => $row['acronyme'] ?? null,
            'couleurs' => $row['couleurs'] ?? null,
            'notes' => $row['notes'] ?? null,
        ];
        try {
            // Adresse complète
            if (!empty($row['adresse'])) {
                $lieuFieldsCreate = \App\Models\Lieu::normalizeFields(explode(',', $row['adresse']), false);
                $lieu = \App\Models\Lieu::findNormalized($lieuFieldsCreate);
                if (!$lieu) {
                    $lieu = \App\Models\Lieu::create($lieuFieldsCreate);
                }
                $data['siege_id'] = $lieu->lieu_id;
            }
            $club = Club::where('nom', $data['nom'])->first();
            if ($club) {
                $club->update($data);
                $this->updated[] = $data['nom'];
            } else {
                $club = Club::create($data);
                $this->created[] = $data['nom'];
            }
        } catch (\Exception $e) {
            $this->errors[] = $row['nom'] ?? '(sans nom)';
            return null;
        }
        try {
            // Gestion des pivots : disciplines
            if (!empty($row['disciplines'])) {
                $disciplineNames = array_map('trim', explode(',', $row['disciplines']));
                $disciplineIds = [];
                foreach ($disciplineNames as $name) {
                    $discipline = \App\Models\Discipline::firstOrCreate(['nom' => $name]);
                    $disciplineIds[] = $discipline->discipline_id;
                }
                $club->disciplines()->sync($disciplineIds);
            }
            // Gestion des pivots : personnes (nom et prénom)
            $personneList = !empty($row['personnes']) ? array_map('trim', explode(',', $row['personnes'])) : [];
            $personneIds = [];
            foreach ($personneList as $fullName) {
                $parts = explode(' ', $fullName, 2);
                $nom = $parts[0] ?? '';
                $prenom = $parts[1] ?? '';
                $personne = \App\Models\Personne::firstOrCreate([
                    'nom' => $nom,
                    'prenom' => $prenom,
                ]);
                $personneIds[] = $personne->id;
            }
            $club->personnes()->sync($personneIds);
        } catch (\Exception $e) {
            // On logue l'erreur mais on ne signale pas le club comme erroné
            \Log::error('Erreur association club (discipline/personne) : ' . ($row['nom'] ?? '(sans nom)') . ' - ' . $e->getMessage());
        }
        return $club;
    }
}
