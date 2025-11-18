<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

abstract class BaseExport implements FromCollection, WithHeadings
{
    protected $ids;

    public function __construct($ids = null)
    {
        $this->ids = $ids;
    }

    /**
     * Récupère la collection d'entités à exporter.
     * À surcharger si besoin de relations ou de requêtes spécifiques.
     */
    protected function getEntities()
    {
        $model = $this->getModelClass();
        $query = $model::query();
        if ($this->ids) {
            $query->whereIn($this->getPrimaryKey(), $this->ids);
        }
        return $query->get();
    }

    /**
     * Retourne le nom de la classe du modèle Eloquent.
     * À définir dans chaque export concret.
     */
    abstract protected function getModelClass();

    /**
     * Retourne le nom de la clé primaire du modèle.
     * À définir dans chaque export concret.
     */
    abstract protected function getPrimaryKey();

    /**
     * Transforme une entité en tableau associatif pour l'export.
     * À surcharger dans chaque export concret.
     */
    abstract protected function transform($entity);

    /**
     * Retourne la collection formatée pour l'export.
     */
    public function collection()
    {
        $entities = $this->getEntities();
        return collect($entities->map(function ($entity) {
            return array_values($this->transform($entity));
        })->toArray());
    }

    /**
     * Retourne les headings (colonnes) de l'export.
     * À définir dans chaque export concret.
     */
    abstract public function headings(): array;

    /**
     * Helpers de formatage (adresses, listes, etc.)
     * Utilisables dans les exports concrets.
     */
    protected function formatAdresse($lieu)
    {
        if (!$lieu) return '';
        $adresse = $lieu->adresse ?? '';
        if (!empty($lieu->code_postal)) {
            $adresse .= ', ' . $lieu->code_postal;
        }
        if (!empty($lieu->commune)) {
            $adresse .= ', ' . $lieu->commune;
        }
        return $adresse;
    }

    protected function formatListe($collection, $attribute = 'nom')
    {
        return $collection->pluck($attribute)->implode(', ');
    }
}
