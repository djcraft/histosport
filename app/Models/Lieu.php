<?php

namespace App\Models;

use App\Models\BaseModel;

class Lieu extends BaseModel
{
    /**
     * Les personnes liées à ce lieu via la table de liaison personne_lieu.
     */
    public function personnes()
    {
        return $this->belongsToMany(Personne::class, 'personne_lieu', 'lieu_id', 'personne_id');
    }

    /**
     * Les sources associées au lieu via le pivot entity_source.
     */
    public function sources()
    {
        return $this->belongsToMany(Source::class, 'entity_source', 'entity_id', 'source_id')
            ->wherePivot('entity_type', 'lieu');
    }

    public static string $entityType = 'lieu';
    protected $fillable = [
        'nom',
        'adresse',
        'code_postal',
        'commune',
        'departement',
        'pays',
    ];

    /**
     * Recherche un lieu avec gestion des nulls et casse (null-safe, insensible à la casse).
     * @param array $fields
     * @return Lieu|null
     */
    public static function findNormalized(array $fields): ?self
    {
        $query = self::query();
        foreach ([
            'nom', 'adresse', 'commune', 'code_postal', 'departement', 'pays'
        ] as $field) {
            $value = $fields[$field] ?? '';
            $query->whereRaw("COALESCE(LOWER(TRIM(" . $field . ")), '') = ?", [mb_strtolower($value)]);
        }
        return $query->first();
    }

    /**
     * Normalise les champs d'un lieu (trim, null si vide, minuscule si recherche).
     * @param array $parts
     * @param bool $forSearch
     * @return array
     */
    public static function normalizeFields(array $parts, bool $forSearch = false): array
    {
        $fields = ['nom', 'adresse', 'commune', 'code_postal', 'departement', 'pays'];
        $normalized = [];
        foreach ($fields as $i => $field) {
            $value = isset($parts[$i]) ? trim($parts[$i]) : null;
            if ($value === '' || $value === null) {
                $normalized[$field] = null;
            } else {
                $normalized[$field] = $forSearch ? mb_strtolower($value) : $value;
            }
        }
        return $normalized;
    }

    /**
     * The table with the model.
     *
     * @var string
     */
    protected $table = 'lieu';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'lieu_id';

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
     * Get the clubs for the lieu.
     */
    /**
     * Les clubs liés à ce lieu via la table de liaison club_lieu.
     */
    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'club_lieu', 'lieu_id', 'club_id');
    }


    public function historisations()
    {
        return $this->morphMany(Historisation::class, 'entity');
    }

        /**
         * Compétitions utilisant ce lieu comme site.
         */
        public function competitions()
        {
            return $this->belongsToMany(Competition::class, 'competition_lieu', 'lieu_id', 'competition_id')
                ->withPivot('type', 'ordre')
                ->withTimestamps();
        }
}
