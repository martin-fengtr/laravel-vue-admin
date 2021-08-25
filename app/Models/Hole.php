<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hole extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'badge_id',
        'status_id',
        'hole_photos',
        'badge_photos',
        'gridline',
        'observations',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'hole_photos' => 'array',
        'badge_photos' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
    ];

    /**
     * Get the status of the hole.
     */
    public function status()
    {
        return $this->haveOne(HoleStatuses::class, 'id', 'status_id');
    }

    /**
     * Get the badge of the hole.
     */
    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }

    /**
     * Get the project of the hole.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
