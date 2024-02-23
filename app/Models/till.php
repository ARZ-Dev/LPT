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

    public function fromTransfer()
    {
        return $this->hasMany(Transfer::class,'from_till_id');
    }

    public function toTransfer()
    {
        return $this->hasMany(Transfer::class,'to_till_id');
    }

    public function tillAmount()
    {
        return $this->hasMany(TillAmount::class,'till_id');
    }
}
