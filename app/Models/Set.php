<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function setGames()
    {
        return $this->hasMany(SetGame::class);
    }

    public function points()
    {
        return $this->hasManyThrough(SetGamePoint::class, SetGame::class);
    }
}
