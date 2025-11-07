<?php

namespace App\Models;

use App\Models\BaseModel;

class Club extends BaseModel
{
    /**
     * Les mandats datés (pivot club_personne).
     */
    public function clubPersonnes()
    {
        return $this->hasMany(ClubPersonne::class, 'club_id', 'club_id');
    }
    public static string $entityType = 'club';
    /**
     * Les attributs assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'nom_origine',
        'surnoms',
        'date_fondation',
        'date_disparition',
        'date_declaration',
        'acronyme',
        'couleurs',
        'siege_id',
        'notes',
        // Ajouté pour permettre l'enregistrement de toutes les colonnes
        // Si d'autres colonnes sont ajoutées à la table clubs, les ajouter ici
    ];
    // ...existing code...

    /**
     * The table with the model.
     *
     * @var string
     */
    protected $table = 'clubs';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'club_id';

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
     * Get the siege associated with the club.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siege()
    {
        return $this->belongsTo(Lieu::class, 'siege_id', 'lieu_id');
    }

    /**
     * The personnes that belong to the club.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function personnes()
    {
        return $this->belongsToMany(Personne::class, 'club_personne', 'club_id', 'personne_id');
    }

    /**
     * The sources that belong to the club.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sources()
    {
        // Utilisation de belongsToMany pour une table pivot personnalisée
        return $this->belongsToMany(Source::class, 'entity_source', 'entity_id', 'source_id')
            ->wherePivot('entity_type', 'club');
    }

    /**
     * The competitions that belong to the club.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function competitions()
    {
        return $this->belongsToMany(Competition::class, 'competition_club', 'club_id', 'competition_id');
    }

    /**
     * The disciplines that belong to the club.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class, 'club_discipline', 'club_id', 'discipline_id');
    }

    public function lieuxUtilises()
    {
        return $this->belongsToMany(Lieu::class, 'club_lieu', 'club_id', 'lieu_id');
    }

    public function sections()
    {
        return $this->belongsToMany(Club::class, 'club_section', 'club_id', 'section_id');
    }

    public function historisations()
    {
        return $this->morphMany(Historisation::class, 'entity');
    }
}
