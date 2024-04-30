<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function till()
    {
        return $this->belongsTo(Till::class,'till_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function receiptAmounts()
    {
        return $this->hasMany(ReceiptAmount::class,'receipt_id');
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class,'tournament_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class,'team_id');
    }

    public static function reportMessage($data)
    {
        echo 'new receipt <u><a href="'. route('receipt.view', ['id' => $data['id'], 'status' => 1]).' "> # '.$data['id'].'</a></u> from   '.$data['paid_by'].'  has been created ';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
