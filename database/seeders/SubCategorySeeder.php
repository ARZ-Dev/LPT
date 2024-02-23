<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
    public function run()
    {
        $subCategories = [
            [
                'category_id' => 1,
                'sub_category_name' => 'SUB 1',
            ],
            [
                'category_id' => 1,
                'sub_category_name' => 'SUB 2',
            ],
            [
                'category_id' => 1,
                'sub_category_name' => 'SUB 3',
            ],

            [
                'category_id' => 2,
                'sub_category_name' => 'SUBX 1',
            ],
            [
                'category_id' => 2,
                'sub_category_name' => 'SUBX 2',
            ],
            [
                'category_id' => 2,
                'sub_category_name' => 'SUBX 3',
            ],

            [
                'category_id' => 3,
                'sub_category_name' => 'SUBXZ 1',
            ],
            [
                'category_id' => 3,
                'sub_category_name' => 'SUBXZ 2',
            ],
            [
                'category_id' => 3,
                'sub_category_name' => 'SUBXZ 3',
            ],

  
        ];


        $timestamp = Carbon::create(2011, 11, 11, 0, 0, 0);

        foreach ($subCategories as $subCategory) {
            $subCategory['created_at'] = $timestamp;
            $subCategory['updated_at'] = $timestamp;
           DB::table('sub_categories')->insertGetId($subCategory);
        }

        
    }
}


