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
                'name' => 'Payment Sub Cat 1',
            ],
            [
                'category_id' => 1,
                'name' => 'Payment Sub Cat 2',
            ],
            [
                'category_id' => 2,
                'name' => 'Payment Sub Cat 3',
            ],
            [
                'category_id' => 2,
                'name' => 'Payment Sub Cat 4',
            ],
            [
                'category_id' => 3,
                'name' => 'Team',
            ],
            [
                'category_id' => 3,
                'name' => 'Player',
            ],
        ];

        foreach ($subCategories as $subCategory) {
            $subCategory['created_at'] = now();
            $subCategory['updated_at'] = now();
            DB::table('sub_categories')->insertGetId($subCategory);
        }


    }
}


