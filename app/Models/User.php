<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Utils\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setFullNameAttribute($value)
    {
        $names = explode(' ', $value);
        $this->attributes['first_name'] = isset($names[0]) ? $names[0] : '';
        $this->attributes['last_name'] = isset($names[1]) ? $names[1] : '';
    }

    public function getFullNameAttribute()
    {
        $first_name = isset($this->attributes['first_name']) ? $this->attributes['first_name'] : '';
        $last_name = isset($this->attributes['last_name']) ? $this->attributes['last_name'] : '';

        return trim($first_name . ' ' . $last_name);
    }


}
