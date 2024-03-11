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
                'user_id' =>  1,
                'name' => 'Cat 1',
            ],
            [
                'user_id' =>  1,
                'name' => 'Cat 2',
            ],
            [
                'user_id' =>  2,
                'name' => 'Cat 3',
            ],

        ];

        foreach ($categoryData as &$category) {
            $category['created_at'] = now();
            $category['updated_at'] = now();

            DB::table('categories')->insertGetId($category);
        }





    }
}


