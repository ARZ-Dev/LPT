<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exchange extends Model
{
    use SoftDeletes;

    protected $table = 'exchanges';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function fromCurrency()
    {
        return $this->belongsto(Currency::class,'from_currency_id');
    }

    public function toCurrency()
    {
        return $this->belongsto(Currency::class,'to_currency_id');
    }
}
