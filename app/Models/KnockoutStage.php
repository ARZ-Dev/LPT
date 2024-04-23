<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnockoutStage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function knockoutRounds()
    {
        return $this->hasMany(KnockoutRound::class);
    }

    public function games()
    {
        return $this->hasManyThrough(Game::class, KnockoutRound::class);
    }

    public function startedGames()
    {
        return $this->games()->where('is_started', true);
    }

    public function groupStagesGames()
    {
        return $this->hasManyThrough(Game::class, Group::class);
    }

    public function startedGroupStagesGames()
    {
        return $this->groupStagesGames()->where('is_started', true);
    }

    public function tournamentDeuceType()
    {
        return $this->belongsTo(TournamentDeuceType::class);
    }

    public function tournamentLevelCategory()
    {
        return $this->belongsTo(TournamentLevelCategory::class);
    }
}
