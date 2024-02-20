<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    use SoftDeletes;
    
    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $guarded = [];
}
