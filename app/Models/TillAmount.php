<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TillAmount extends Model
{
    use SoftDeletes;
    protected $table = 'till_amounts';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function till()
    {
        return $this->belongsTo(Till::class,'till_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
