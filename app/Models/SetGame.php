<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetGame extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function set()
    {
        return $this->belongsTo(Set::class);
    }
}
