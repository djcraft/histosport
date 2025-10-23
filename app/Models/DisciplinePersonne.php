<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisciplinePersonne extends Model
{
    public static string $entityType = 'discipline_personne';
    protected $table = 'discipline_personne';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'discipline_id',
        'personne_id',
    ];
}
