<?php

namespace App\Imports;

use App\Models\Club;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class ClubImport implements ToModel, WithHeadingRow
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
            // Adresse complète
            if (!empty($row['adresse'])) {
                $adresseParts = array_map('trim', explode(',', $row['adresse']));
                $lieu = \App\Models\Lieu::firstOrCreate([
                    'adresse' => $adresseParts[0] ?? '',
                    'code_postal' => $adresseParts[1] ?? '',
                    'commune' => $adresseParts[2] ?? '',
                ]);
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
            // Gestion des pivots : disciplines
            if (!empty($row['disciplines'])) {
                $disciplineNames = array_map('trim', explode(',', $row['disciplines']));
                $disciplineIds = [];
                foreach ($disciplineNames as $name) {
                    $discipline = \App\Models\Discipline::firstOrCreate(['nom' => $name]);
                    $disciplineIds[] = $discipline->id;
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
            return $club;
        } catch (\Exception $e) {
            $this->errors[] = $row['nom'] ?? '(sans nom)';
            return null;
        }
    }
}
