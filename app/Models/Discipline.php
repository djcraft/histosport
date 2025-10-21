<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    /** @use HasFactory<\Database\Factories\DisciplineFactory> */
    use HasFactory;

    /**
     * The table with the model.
     *
     * @var string
     */
    protected $table = 'discipline';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'discipline_id';

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
     * Get the clubs for the discipline.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'club_discipline', 'discipline_id', 'club_id');
    }

    /**
     * The personnes that belong to the discipline.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function personnes()
    {
        return $this->belongsToMany(Personne::class, 'discipline_personne', 'discipline_id', 'personne_id');
    }
}
