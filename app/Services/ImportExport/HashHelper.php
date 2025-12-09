<?php
namespace App\Services\ImportExport;

class HashHelper
{
    /**
     * Génère un hash canonique à partir d'un tableau de données normalisées.
     * Les valeurs nulles et vides sont considérées comme identiques.
     * @param array $normalizedData
     * @return string
     */
    public static function generate(array $normalizedData): string
    {
        // Remplacer null/'' par une valeur standard
        $canonical = array_map(function ($value) {
            return ($value === null || $value === '') ? 'NULL' : $value;
        }, $normalizedData);
        // Tri des clés pour garantir l'ordre
        ksort($canonical);
        // Concaténation canonique
        $string = implode('|', $canonical);
        // Hash (SHA256)
        return hash('sha256', $string);
    }
}
