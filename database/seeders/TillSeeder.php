<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TillSeeder extends Seeder
{
    public function run()
    {
        $tills = [
            [
                'created_by' => 1,
                'user_id' => 1,
                'name' => 'wael'
            ],
            [
                'created_by' => 1,
                'user_id' => 2,
                'name' => 'pico'
            ],
        ];
        foreach ($tills as $till) {
            $till['created_at'] = now();
            $till['updated_at'] = now();
            DB::table('tills')->insertGetId($till);
        }


    }
}


