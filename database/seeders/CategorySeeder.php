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
                'name' => 'Payment Cat 1',
                'type' => 'payment',
            ],
            [
                'user_id' =>  1,
                'name' => 'Payment Cat 2',
                'type' => 'payment',
            ],
            [
                'user_id' =>  1,
                'name' => 'Tournament Receipts',
                'type' => 'receipt',
            ],
        ];

        foreach ($categoryData as &$category) {
            $category['created_at'] = now();
            $category['updated_at'] = now();

            DB::table('categories')->insertGetId($category);
        }





    }
}


