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
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    /**
     * Accessor method to get the full name attribute.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function till()
    {
        return $this->hasMany(Till::class,'user_id');
    }

    public function receipt()
    {
        return $this->hasMany(Receipt::class,'user_id');
    }

    public function category()
    {
        return $this->hasMany(Category::class,'user_id');
    }

    public function currency()
    {
        return $this->hasMany(Currency::class,'user_id');
    }

    public function tillCreatedBy()
    {
        return $this->hasMany(Till::class,'created_by');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class,'user_id');
    }

    public function transfer()
    {
        return $this->hasMany(Transfer::class,'user_id');
    }

    public function exchnage()
    {
        return $this->hasMany(Exchange::class,'user_id');
    }

    


}
