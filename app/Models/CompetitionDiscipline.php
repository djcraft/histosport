<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionDiscipline extends Model
{
    public static string $entityType = 'competition_discipline';
    protected $table = 'competition_discipline';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'competition_id',
        'discipline_id',
    ];
}
