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

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function fromTill()
    {
        return $this->belongsTo(Till::class,'from_till_id');
    }

    public function toTill()
    {
        return $this->belongsTo(Till::class,'to_till_id');
    }
    public function transferAmounts()
    {
        return $this->hasMany(TransferAmount::class,'transfer_id');
    }


    public static function reportMessage($data){
        echo 'new transfer <u><a href="'. route('transfer.view', ['id' => $data['id'], 'status' => 1]).' "> # '.$data['id'].'</a></u> '.$data['name'].' from <u><a href="'. route('till.edit', $data['from_till_id']).' "> '.$data['from_till_id']->name.' </a></u> to <u><a href="'. route('till.edit', $data['to_till_id']).' ">'.$data['to_till_id']->name.' </a></u>  has been created ';
    }


}
