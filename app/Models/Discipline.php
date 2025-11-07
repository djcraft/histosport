<?php

namespace App\Models;

use App\Models\BaseModel;

class Discipline extends BaseModel
{
    public static string $entityType = 'discipline';
    // ...existing code...
    protected $fillable = ['nom', 'description'];
    /**
     * The table with the model.
     *
     * @var string
     */
    protected $table = 'disciplines';

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


    public function historisations()
    {
        return $this->morphMany(Historisation::class, 'entity');
    }
}
