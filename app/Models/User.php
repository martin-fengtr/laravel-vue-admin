<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use HasApiTokens;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'address',
        'company_id',
        'role_id',
        'status_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
    ];

    /**
     *
     * Get all of the projects of the user.
     *
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     *
     * Get all of the projects of the user.
     *
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     *
     * Get the status of the user.
     *
     */
    public function status()
    {
        return $this->belongsTo(UserStatus::class);
    }

    /**
     *
     * Get the role of the user.
     *
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
