<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlyEntryAmount extends Model
{
    use SoftDeletes;

    protected $table = 'monthly_entry_amounts';
    protected $primaryKey = 'id';

    protected $guarded = [];



    public function monthlyEntry()
    {
        return $this->belongsTo(MonthlyEntry::class,'monthly_entry_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }
}
