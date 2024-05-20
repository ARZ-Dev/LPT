<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TournamentLevelCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function type()
    {
        return $this->belongsTo(TournamentType::class, 'tournament_type_id');
    }

    public function teams()
    {
        return $this->hasMany(TournamentLevelCategoryTeam::class);
    }

    public function knockoutRounds()
    {
        return $this->hasMany(KnockoutRound::class);
    }

    public function knockoutStages()
    {
        return $this->hasMany(KnockoutStage::class);
    }

    public function levelCategory()
    {
        return $this->belongsTo(LevelCategory::class);
    }

    public function knockoutsMatches()
    {
        return $this->hasManyThrough(Game::class, KnockoutRound::class);
    }

    public function groupStageMatches()
    {
        return $this->hasManyThrough(Game::class, Group::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function winnerTeam()
    {
        return $this->belongsTo(Team::class);
    }

    public function groupStage()
    {
        return $this->hasOne(KnockoutStage::class)->where('name', 'Group Stages');
    }
}
