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

    public function tills()
    {
        return $this->hasMany(Till::class);
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function currencies()
    {
        return $this->hasMany(Currency::class);
    }

    public function tillsCreatedBy()
    {
        return $this->hasMany(Till::class,'created_by');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

    public function exchanges()
    {
        return $this->hasMany(Exchange::class);
    }

    public function monthlyEntries()
    {
        return $this->hasMany(MonthlyEntry::class);
    }

    public function monthlyEntriesCreatedBy()
    {
        return $this->hasMany(MonthlyEntry::class,'created_by');
    }

}
