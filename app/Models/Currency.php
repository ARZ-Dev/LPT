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

    public function paymentAmount()
    {
        return $this->hasMany(PaymentAmount::class,'currency_id');
    }
    public function receiptAmount()
    {
        return $this->hasMany(ReceiptAmount::class,'currency_id');
    }
}