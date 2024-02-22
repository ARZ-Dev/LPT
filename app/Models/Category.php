<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use SoftDeletes;
    
    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function subCategory()
    {
        return $this->hasMany(SubCategory::class,'category_id');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class,'category_id');
    }
}
