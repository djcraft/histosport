<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    /** @use HasFactory<\Database\Factories\CompetitionFactory> */
    use HasFactory;

    protected $table = 'competitions';
    protected $primaryKey = 'competition_id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nom',
        'date',
        'lieu_id',
        'organisateur_club_id',
        'organisateur_personne_id',
        'type',
        'duree',
        'niveau',
    ];

    /**
     * Lieu de la compétition.
     */
    public function lieu()
    {
        return $this->belongsTo(Lieu::class, 'lieu_id', 'lieu_id');
    }

    /**
     * Club organisateur de la compétition.
     */
    public function organisateur_club()
    {
        return $this->belongsTo(Club::class, 'organisateur_club_id', 'club_id');
    }

    /**
     * Personne organisatrice de la compétition.
     */
    public function organisateur_personne()
    {
        return $this->belongsTo(Personne::class, 'organisateur_personne_id', 'personne_id');
    }

    /**
     * Retourne tous les participants (clubs ou personnes) à la compétition.
     */
    public function participants()
    {
        return $this->hasMany(CompetitionParticipant::class, 'competition_id', 'competition_id');
    }

    /**
     * Les disciplines associées à la compétition.
     */
    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class, 'competition_discipline', 'competition_id', 'discipline_id');
    }

    public function sources()
    {
        // Utilisation de belongsToMany pour une table pivot personnalisée
        return $this->belongsToMany(Source::class, 'entity_source', 'entity_id', 'source_id')
            ->wherePivot('entity_type', 'competition');
    }

    public function historisations()
    {
        return $this->morphMany(Historisation::class, 'entity');
    }
}
