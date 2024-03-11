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
                'name' => 'SUB 1',
            ],
            [
                'category_id' => 1,
                'name' => 'SUB 2',
            ],
            [
                'category_id' => 1,
                'name' => 'SUB 3',
            ],

            [
                'category_id' => 2,
                'name' => 'SUBX 1',
            ],
            [
                'category_id' => 2,
                'name' => 'SUBX 2',
            ],
            [
                'category_id' => 2,
                'name' => 'SUBX 3',
            ],

            [
                'category_id' => 3,
                'name' => 'SUBXZ 1',
            ],
            [
                'category_id' => 3,
                'name' => 'SUBXZ 2',
            ],
            [
                'category_id' => 3,
                'name' => 'SUBXZ 3',
            ],


        ];

        foreach ($subCategories as $subCategory) {
            $subCategory['created_at'] = now();
            $subCategory['updated_at'] = now();
            DB::table('sub_categories')->insertGetId($subCategory);
        }


    }
}


