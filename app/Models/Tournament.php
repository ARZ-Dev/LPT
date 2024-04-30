<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tournament extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function levelCategories()
    {
        return $this->hasMany(TournamentLevelCategory::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function receipts()
    {
        return $this->belongsTo(Receipt::class);
    }
}
