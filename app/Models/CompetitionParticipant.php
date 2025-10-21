<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionParticipant extends Model
{
    protected $table = 'competition_participant';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'competition_id',
        'club_id',
        'personne_id',
        'resultat',
        'source_id',
    ];

    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id', 'competition_id');
    }

    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id', 'club_id');
    }

    public function personne()
    {
        return $this->belongsTo(Personne::class, 'personne_id', 'personne_id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'source_id');
    }
}
