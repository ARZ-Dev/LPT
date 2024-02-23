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
                'user_id' => 1,
                'name' => 'wael'
            ], 
            [
                'user_id' => 2,
                'name' => 'pico'
            ], 
        ];
        $timestamp = Carbon::create(2011, 11, 11, 0, 0, 0);
        foreach ($tills as $till) {
            $till['created_at'] = $timestamp;
            $till['updated_at'] = $timestamp;
           DB::table('tills')->insertGetId($till);
        }

        
    }
}


