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
                'name' => 'Dollar',
                'symbol' => '$',
             
            ],
            [
                'name' => 'Euro',
                'symbol' => '€',

            ],
            [
                'name' => 'Lira',
                'symbol' => 'L£',

            ],
        ];

        $timestamp = Carbon::create(2011, 11, 11, 0, 0, 0);

        foreach ($currencies as $currency) {
            $currency['created_at'] = $timestamp;
            $currency['updated_at'] = $timestamp;
           DB::table('currencies')->insertGetId($currency);
        }

        
    }
}


