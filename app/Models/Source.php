<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    /** @use HasFactory<\Database\Factories\SourceFactory> */
    use HasFactory;

    /**
     * The table with the model.
     *
     * @var string
     */
    protected $table = 'source';

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'source_id';

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
     * Get the clubs for the source.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'club_source', 'source_id', 'club_id');
    }
}
