<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Till extends Model
{
    use SoftDeletes;
    protected $table = 'tills';
    protected $primaryKey = 'id';

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function fromTransfer()
    {
        return $this->hasMany(Transfer::class,'from_till_id');
    }

    public function toTransfer()
    {
        return $this->hasMany(Transfer::class,'to_till_id');
    }

    public function tillAmounts()
    {
        return $this->hasMany(TillAmount::class,'till_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class,'till_id');
    }
    public function monthlyEntry()
    {
        return $this->hasMany(MonthlyEntry::class,'till_id');
    }

    public function openedMonthlyEntry()
    {
        return $this->hasMany(MonthlyEntry::class)->whereNull('close_date');
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class,'till_id');
    }

    public static function reportMessage($data)
    {
        echo 'new till <u><a href="'. route('till.view', ['id' => $data['id'], 'status' => 1]).' "> # '.$data['id'].'</a></u>  '.$data['name'].'  has been created ';

    }
}
