<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TournamentLevelCategoryTeam extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function tournamentLevelCategory()
    {
        return $this->belongsTo(TournamentLevelCategory::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
