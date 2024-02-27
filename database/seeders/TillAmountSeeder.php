<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TillAmountSeeder extends Seeder
{
    public function run()
    {
        $tillAmounts = [
            [
                'till_id' => 1,
                'amount' => 100,
                'currency_id' => 1,

            ], 
            [
                'till_id' => 1,
                'amount' => 50,
                'currency_id' => 2,

            ],
            [
                'till_id' => 1,
                'amount' => 1000000,
                'currency_id' => 3,
            ],
            [
                'till_id' => 2,
                'amount' => 50,
                'currency_id' => 1,

            ], 
            [
                'till_id' => 2,
                'amount' => 500000,
                'currency_id' => 3,

            ],  
        ];
        $timestamp = Carbon::create(2011, 11, 11, 0, 0, 0);
        foreach ($tillAmounts as $tillAmount) {
            $till['created_at'] = $timestamp;
            $till['updated_at'] = $timestamp;
           DB::table('till_amounts')->insertGetId($tillAmount);
        }

        
    }
}


