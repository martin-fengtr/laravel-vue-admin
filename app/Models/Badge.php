<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Badge extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'hex',
    ];

    /**
     *
     * Get the hole of the badge.
     *
     */
    public function hole()
    {
        return $this->hasOne(Hole::class, 'badge_id', 'id');
    }
}
