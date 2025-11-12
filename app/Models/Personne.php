<?php

namespace App\Models;

use App\Models\BaseModel;

class Personne extends BaseModel
{
    /**
     * Les participations de la personne aux compétitions.
     */
    public function competitionParticipants()
    {
        return $this->hasMany(CompetitionParticipant::class, 'personne_id', 'personne_id');
    }
    /**
     * Les mandats datés (pivot club_personne).
     */
    public function clubPersonnes()
    {
        return $this->hasMany(ClubPersonne::class, 'personne_id', 'personne_id');
    }
    public static string $entityType = 'personne';
    /**
     * Lieu de naissance de la personne.
     */
    public function lieu_naissance()
    {
        return $this->belongsTo(Lieu::class, 'lieu_naissance_id', 'lieu_id');
    }

    /**
     * Lieu de décès de la personne.
     */
    public function lieu_deces()
    {
        return $this->belongsTo(Lieu::class, 'lieu_deces_id', 'lieu_id');
    }
    /**
     * Les attributs assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'date_naissance_precision',
        'lieu_naissance_id',
        'date_deces',
        'date_deces_precision',
        'lieu_deces_id',
        'sexe',
        'titre',
        'adresse_id',
    ];
    // ...existing code...

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

    /**
     * Les sources associées à la personne via le pivot entity_source (fonctionnement identique à Club).
     */
    public function sources()
    {
        return $this->belongsToMany(Source::class, 'entity_source', 'entity_id', 'source_id')
            ->wherePivot('entity_type', 'personne');
    }

    /**
     * Lieu d'adresse de la personne.
     */
    public function adresse()
    {
        return $this->belongsTo(Lieu::class, 'adresse_id', 'lieu_id');
    }

    public function historisations()
    {
        return $this->morphMany(Historisation::class, 'entity');
    }
}
