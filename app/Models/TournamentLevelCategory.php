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

    public function knockoutRound()
    {
        return $this->hasMany(KnockoutRound::class);
    }
    
    public function levelCategory()
    {
        return $this->belongsTo(LevelCategory::class);
    }
}
