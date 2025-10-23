<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lieu extends Model
{
    public static string $entityType = 'lieu';
    protected $fillable = [
        'adresse',
        'code_postal',
        'commune',
        'departement',
        'pays',
    ];
    /** @use HasFactory<\Database\Factories\LieuFactory> */
    use HasFactory;

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
}
