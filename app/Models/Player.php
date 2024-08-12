<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Accessor method to get the full name attribute.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function getShortFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function currentTeam()
    {
        return $this->belongsTo(Team::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
}
