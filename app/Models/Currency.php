<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;

    
    protected $table = 'currencies';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    

    public function paymentAmount()
    {
        return $this->hasMany(PaymentAmount::class,'currency_id');
    }
    
    public function receiptAmount()
    {
        return $this->hasMany(ReceiptAmount::class,'currency_id');
    }

    public function exchangeTo()
    {
        return $this->hasMany(Exchange::class,'from_currency_id');
    }

    public function exchangeFrom()
    {
        return $this->hasMany(Exchange::class,'to_currency_id');
    }

    public static function reportMessage($data){
        echo 'new currency <u><a href="'. route('currency.view', ['id' => $data['id'], 'status' => 1]).' "> # '.$data['id'].'</a></u> '.$data['name'].' has been created ';


    }
}
