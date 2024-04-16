<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupTeam extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
