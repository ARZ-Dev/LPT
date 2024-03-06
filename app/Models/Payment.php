<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $table = 'payments';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function till()
    {
        return $this->belongsTo(Till::class,'till_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    public function paymentAmount()
    {
        return $this->hasMany(PaymentAmount::class,'payment_id');
    }

    public static function reportMessage($data){
        echo 'new payment <u><a href="'. route('payment.view', ['id' => $data['id'], 'status' => 1]).' ">#'.$data['id'].'</a></u> has been created';


    }



    
}
