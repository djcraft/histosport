<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubDiscipline extends Model
{
    public static string $entityType = 'club_discipline';
    protected $table = 'club_discipline';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'club_id',
        'discipline_id',
    ];
}
