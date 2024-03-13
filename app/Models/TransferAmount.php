<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransferAmount extends Model
{
    use SoftDeletes;

    protected $table = 'transfer_amounts';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function transfer()
    {
        return $this->belongsTo(Transfer::class,'transfer_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }
}
