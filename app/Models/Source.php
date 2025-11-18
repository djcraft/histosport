<?php

namespace App\Models;

use App\Models\BaseModel;

class Source extends BaseModel
{
    public static string $entityType = 'source';
    /**
     * Les attributs assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'auteur',
        'annee_reference',
        'type',
        'cote',
        'url',
        'lieu_edition_id',
        'lieu_conservation_id',
        'lieu_couverture_id',
    ];
    // ...existing code...

    /**
     * The table with the model.
     *
     * @var string
     */
    protected $table = 'sources';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'source_id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */

    public $timestamps = true;

    /**
     * Get the clubs for the source.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'entity_source', 'source_id', 'entity_id')
            ->wherePivot('entity_type', 'club');
    }

    public function personnes()
    {
        return $this->morphToMany(Personne::class, 'entity', 'entity_source', 'source_id', 'entity_id')
            ->wherePivot('entity_type', 'personne');
    }

    // Relation disciplines supprimée : non associée aux sources

    public function competitions()
    {
        return $this->belongsToMany(Competition::class, 'entity_source', 'source_id', 'entity_id')
            ->wherePivot('entity_type', 'competition');
    }

    public function lieux()
    {
        return $this->morphToMany(Lieu::class, 'entity', 'entity_source', 'source_id', 'entity_id')
            ->wherePivot('entity_type', 'lieu');
    }

    public function historisations()
    {
        return $this->morphMany(Historisation::class, 'entity');
    }

    /**
     * Lieu d'édition de la source.
     */
    public function lieuEdition()
    {
        return $this->belongsTo(Lieu::class, 'lieu_edition_id', 'lieu_id');
    }

    /**
     * Lieu de conservation de la source.
     */
    public function lieuConservation()
    {
        return $this->belongsTo(Lieu::class, 'lieu_conservation_id', 'lieu_id');
    }

    /**
     * Lieu de couverture de la source.
     */
    public function lieuCouverture()
    {
        return $this->belongsTo(Lieu::class, 'lieu_couverture_id', 'lieu_id');
    }
    /**
     * Recherche une source normalisée selon les champs principaux.
     */
    public static function findNormalized($fields)
    {
        $query = self::query();
        foreach ([
            'titre', 'auteur', 'annee_reference', 'type'
        ] as $field) {
            $value = $fields[$field] ?? '';
            $query->whereRaw("COALESCE(LOWER(TRIM($field)), '') = ?", [mb_strtolower($value)]);
        }
        return $query->first();
    }

    /**
     * Normalise les champs pour la comparaison et la déduplication.
     */
    public static function normalizeFields($fields, $assoc = true)
    {
        $normalized = [];
    $keys = ['titre', 'auteur', 'annee_reference', 'type'];
        foreach ($keys as $i => $key) {
            $value = $assoc ? ($fields[$key] ?? '') : ($fields[$i] ?? '');
            $normalized[$key] = mb_strtolower(trim((string)($value ?? '')));
        }
        return $normalized;
    }
}
