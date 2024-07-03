<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function players()
    {
        return $this->belongsToMany(Player::class);
    }

    public function levelCategory()
    {
        return $this->belongsTo(LevelCategory::class);
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function currentPlayers()
    {
        return $this->hasMany(Player::class, 'current_team_id');
    }

    public function rankings()
    {
        return $this->hasMany(TournamentLevelCategoryTeam::class);
    }

    public function monitorUser()
    {
        return $this->belongsTo(User::class, 'monitor_user_id');
    }

}
