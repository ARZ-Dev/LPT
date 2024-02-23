<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use SoftDeletes;

    protected $table = 'transfers';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function fromTill()
    {
        return $this->belongsTo(Till::class,'from_till_id');
    }

    public function toTill()
    {
        return $this->belongsTo(Till::class,'to_till_id');
    }


}
