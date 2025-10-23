<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubPersonne extends Model
{
    public static string $entityType = 'club_personne';
    protected $table = 'club_personne';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'club_id',
        'personne_id',
    ];
}
