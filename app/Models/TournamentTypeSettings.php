<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentTypeSettings extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function tournamentType()
    {
        return $this->belongsTo(TournamentType::class);
    }
}
