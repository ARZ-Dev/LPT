<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use SoftDeletes;

    protected $table = 'receipts';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function receiptAmount()
    {
        return $this->hasMany(ReceiptAmount::class,'receipt_id');
    }
    public static function reportMessage($data){
        echo 'new receipt <u><a href="'. route('receipt.view', ['id' => $data['id'], 'status' => 1]).' "> # '.$data['id'].'</a></u> from   '.$data['paid_by'].'  has been created ';
    }
}
