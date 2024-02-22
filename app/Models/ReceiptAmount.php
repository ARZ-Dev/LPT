<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptAmount extends Model
{
    use SoftDeletes;

    protected $table = 'receipt_amounts';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function receipt()
    {
        return $this->belongsTo(Receipt::class,'receipt_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }
}
