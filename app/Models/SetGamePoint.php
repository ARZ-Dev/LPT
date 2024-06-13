<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetGamePoint extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setGame()
    {
        return $this->belongsTo(SetGame::class);
    }

    public function pointTeam()
    {
        return $this->belongsTo(Team::class, 'point_team_id');
    }
}
