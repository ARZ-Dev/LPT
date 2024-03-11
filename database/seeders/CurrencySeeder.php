<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $currencies = [
            [
                'user_id'=> 2,
                'name' => 'USD',
                'symbol' => '$',
                'list_order' => '2',
            ],
            [
                'user_id'=> 3,
                'name' => 'Euro',
                'symbol' => '€',
                'list_order' => '1',
            ],
            [
                'user_id'=> 1,
                'name' => 'LBP',
                'symbol' => 'L£',
                'list_order' => '3',
            ],
        ];

        foreach ($currencies as $currency) {
            $currency['created_at'] = now();
            $currency['updated_at'] = now();
            DB::table('currencies')->insertGetId($currency);
        }


    }
}


