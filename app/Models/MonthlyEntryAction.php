<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyEntryAction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function monthlyEntry()
    {
        return $this->belongsTo(MonthlyEntry::class);
    }
}
