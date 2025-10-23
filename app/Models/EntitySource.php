<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntitySource extends Model
{
    public static string $entityType = 'entity_source';
    protected $table = 'entity_source';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'entity_type',
        'entity_id',
        'source_id',
        'date_source',
        'commentaire',
    ];
}
