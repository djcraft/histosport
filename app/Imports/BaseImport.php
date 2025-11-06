<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

/**
 * Classe abstraite pour factoriser la logique commune des imports.
 * Les imports spécifiques hériteront de cette classe et implémenteront la méthode model().
 */
abstract class BaseImport implements ToModel, WithHeadingRow
{
    /**
     * Suivi des entités créées lors de l'import
     * @var array
     */
    public $created = [];

    /**
     * Suivi des entités mises à jour lors de l'import
     * @var array
     */
    public $updated = [];

    /**
     * Suivi des erreurs rencontrées lors de l'import
     * @var array
     */
    public $errors = [];
    /**
     * Logique commune pour tous les imports :
     * - Validation des données
     * - Logging des erreurs
     * - Transformation des données si besoin
     * La méthode model() doit être implémentée dans chaque import spécifique.
     */
    public function onRowError($e)
    {
        Log::error('Erreur d\'import : ' . $e->getMessage());
    }

    // Méthode à implémenter dans chaque import spécifique
    abstract public function model(array $row);
}