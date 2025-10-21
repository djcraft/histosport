<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    /** @use HasFactory<\Database\Factories\ClubFactory> */
    use HasFactory;

    /**
     * The table with the model.
     *
     * @var string
     */
    protected $table = 'club';

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
        return $this->belongsTo(Lieu::class, 'siege', 'lieu_id');
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
        return $this->belongsToMany(Source::class, 'club_source', 'club_id', 'source_id');
    }

    /**
     * The competitions that belong to the club.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function competitions()
    {
        return $this->belongsToMany(Competition::class, 'club_competition', 'club_id', 'competition_id');
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
}
