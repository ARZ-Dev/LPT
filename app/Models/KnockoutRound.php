<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnockoutRound extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tournamentLevelCategory()
    {
        return $this->belongsTo(TournamentLevelCategory::class);
    }
}
