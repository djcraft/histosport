<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lieu extends Model
{
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

    public $timestamps = false;

    /**
     * Get the clubs for the lieu.
     */
    public function clubs()
    {
        return $this->hasMany(Club::class, 'siege', 'lieu_id');
    }
}
