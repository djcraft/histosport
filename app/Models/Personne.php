<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personne extends Model
{
    /**
     * Les attributs assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance_id',
        'date_deces',
        'lieu_deces_id',
        'sexe',
        'titre',
        'adresse_id',
    ];
    /** @use HasFactory<\Database\Factories\PersonneFactory> */
    use HasFactory;

    /**
     * The table with the model.
     *
     * @var string
     */
    protected $table = 'personnes';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'personne_id';

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
     * The clubs that belong to the personne.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'club_personne', 'personne_id', 'club_id');
    }

    /**
     * The disciplines that belong to the personne.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class, 'discipline_personne', 'personne_id', 'discipline_id');
    }

    public function sources()
    {
        return $this->morphToMany(Source::class, 'entity', 'entity_source', 'entity_id', 'source_id')
            ->wherePivot('entity_type', 'personne');
    }

    public function historisations()
    {
        return $this->morphMany(Historisation::class, 'entity');
    }
}
