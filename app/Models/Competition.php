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
    protected $table = 'competition';

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
    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'club_competition', 'competition_id', 'club_id');
    }
}
