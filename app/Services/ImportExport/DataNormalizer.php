<?php
namespace App\Services\ImportExport;

class DataNormalizer
{
    /**
     * Normalise une ligne de données selon le type d'entité.
     * @param array $row
     * @param string $type
     * @return array
     */
    public static function normalize(array $row, string $type): array
    {
        switch ($type) {
            case 'club':
                return self::normalizeClub($row);
            case 'competition':
                return self::normalizeCompetition($row);
            // Ajouter d'autres entités ici
            default:
                return self::normalizeGeneric($row);
        }
    }

    protected static function normalizeClub(array $row): array
    {
        // Exemple de normalisation pour un club
        return [
            'nom' => trim(mb_strtolower($row['nom'] ?? '')),
            'nom_origine' => trim(mb_strtolower($row['nom_origine'] ?? '')),
            'acronyme' => trim(mb_strtolower($row['acronyme'] ?? '')),
            // Ajouter d'autres champs à normaliser
        ];
    }

    protected static function normalizeCompetition(array $row): array
    {
        // Exemple de normalisation pour une compétition
        return [
            'nom' => trim(mb_strtolower($row['nom'] ?? '')),
            'date' => trim($row['date'] ?? ''),
            // Ajouter d'autres champs à normaliser
        ];
    }

    protected static function normalizeGeneric(array $row): array
    {
        // Normalisation générique (tous les champs en minuscules/trim)
        $normalized = [];
        foreach ($row as $key => $value) {
            $normalized[$key] = is_string($value) ? trim(mb_strtolower($value)) : $value;
        }
        return $normalized;
    }
}
