<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lieu extends Model
{
    public static string $entityType = 'lieu';
    protected $fillable = [
        'nom',
        'adresse',
        'code_postal',
        'commune',
        'departement',
        'pays',
    ];
    /** @use HasFactory<\Database\Factories\LieuFactory> */
    use HasFactory;

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
            $value = $fields[$field] ?? null;
            if ($value === null) {
                $query->whereNull($field);
            } else {
                $query->whereRaw('lower(' . $field . ') = ?', [mb_strtolower($value)]);
            }
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
    public function clubs()
    {
        return $this->hasMany(Club::class, 'siege_id', 'lieu_id');
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
