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
}
