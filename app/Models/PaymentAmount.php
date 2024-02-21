<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentAmount extends Model
{
    use SoftDeletes;

    protected $table = 'payment_amounts';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function payment()
    {
        return $this->belongsTo(Payment::class,'payment_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }
}
