<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{


    public function run()
    {

     
        $categoryData = [
            [
                'category_name' => 'Cat 1',
            ],
            [
                'category_name' => 'Cat 2',
            ],
            [
                'category_name' => 'Cat 3',
            ],
  
        ];

        $timestamp = Carbon::create(2011, 11, 11, 0, 0, 0);

        foreach ($categoryData as &$category) {
            $category['created_at'] = $timestamp;
            $category['updated_at'] = $timestamp;
        
            DB::table('categories')->insertGetId($category);
        }




        
    }
}


