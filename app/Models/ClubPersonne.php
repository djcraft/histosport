<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubPersonne extends Model
{
    /**
     * Relation avec le club.
     */
    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id', 'club_id');
    }

    /**
     * Relation avec la personne.
     */
    public function personne()
    {
        return $this->belongsTo(Personne::class, 'personne_id', 'personne_id');
    }
    public static string $entityType = 'club_personne';
    protected $table = 'club_personne';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'club_id',
        'personne_id',
        'role',
        'date_debut',
        'date_debut_precision',
        'date_fin',
        'date_fin_precision',
    ];
}
