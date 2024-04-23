<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'group_teams');
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function knockoutStage()
    {
        return $this->belongsTo(KnockoutStage::class);
    }
}
