<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historisation extends Model
{
    protected $table = 'historisations';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'entity_type',
        'entity_id',
        'utilisateur_id',
        'action',
        'donnees_avant',
        'donnees_apres',
        'date',
    ];

    public function entity()
    {
        return $this->morphTo();
    }

    /**
     * L'utilisateur ayant effectué la modification.
     */
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id', 'id');
    }
}
