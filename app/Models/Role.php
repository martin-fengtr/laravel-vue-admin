<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'add_hole',
        'insp_filter',
        'ad_hoc_insp',
        'update_hole',
        'report_problem',
        'replace_badge',
        'create_report',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'add_hole' => 'boolean',
        'insp_filter' => 'boolean',
        'ad_hoc_insp' => 'boolean',
        'update_hole' => 'boolean',
        'report_problem' => 'boolean',
        'replace_badge' => 'boolean',
        'create_report' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];
}
