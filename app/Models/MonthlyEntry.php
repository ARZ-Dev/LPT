<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlyEntry extends Model
{
    use SoftDeletes;

    protected $table = 'monthly_entries';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsto(User::class,'user_id');
    }

    public function createdby()
    {
        return $this->belongsto(User::class,'created_by');
    }

    public function till()
    {
        return $this->belongsto(Till::class,'till_id');
    }

    public function monthlyEntryAmounts()
    {
        return $this->hasMany(MonthlyEntryAmount::class,'monthly_entry_id');
    }

    public function allAmountsClosed()
    {
        if ($this->close_date) {
            foreach ($this->monthlyEntryAmounts as $monthlyEntryAmount) {
                if ($monthlyEntryAmount->amount != $monthlyEntryAmount->closing_amount) {
                    return false;
                }
            }
        }
        return true;
    }
}
