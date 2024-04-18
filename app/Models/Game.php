<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function winnerTeam()
    {
        return $this->belongsTo(Team::class, 'winner_team_id');
    }
    public function looserTeam()
    {
        return $this->belongsTo(Team::class, 'loser_team_id');
    }

    public function loserTeam()
    {
        return $this->belongsTo(Team::class, 'loser_team_id');
    }

    public function knockoutRound()
    {
        return $this->belongsTo(KnockoutRound::class);
    }

    public function relatedHomeGame()
    {
        return $this->belongsTo(Game::class);
    }

    public function relatedAwayGame()
    {
        return $this->belongsTo(Game::class);
    }

    public function sets()
    {
        return $this->hasMany(Set::class);
    }

}
