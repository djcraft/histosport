<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    /** @use HasFactory<\Database\Factories\CompetitionFactory> */
    use HasFactory;

    /**
     * The table with the model.
     *
     * @var string
     */
    protected $table = 'competitions';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'competition_id';

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
     * Get the clubs for the competition.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    /**
     * Retourne tous les participants (clubs ou personnes) à la compétition.
     */
    public function participants()
    {
        return $this->hasMany(CompetitionParticipant::class, 'competition_id', 'competition_id');
    }

    public function sources()
    {
        return $this->morphToMany(Source::class, 'entity', 'entity_source', 'entity_id', 'source_id')
            ->wherePivot('entity_type', 'competition');
    }

    public function historisations()
    {
        return $this->morphMany(Historisation::class, 'entity');
    }
}
