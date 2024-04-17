<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsSeeder extends Seeder
{
    public function run()
    {
        $TeamsData  = [
            ['nickname' => 'Satrs', 'level_category_id' => 1],
            ['nickname' => 'Sharky', 'level_category_id' => 1],
            ['nickname' => 'Bad Boys', 'level_category_id' => 1],
            ['nickname' => 'Luna', 'level_category_id' => 1],
            ['nickname' => 'Kotowato', 'level_category_id' => 1],
            ['nickname' => 'Pista Dalista', 'level_category_id' => 1],
            ['nickname' => 'Jebrony', 'level_category_id' => 1],
            ['nickname' => 'LaNight', 'level_category_id' => 1],
            ['nickname' => 'WatchMens', 'level_category_id' => 1],
            ['nickname' => 'Witchers', 'level_category_id' => 1],
        ];

        foreach ($TeamsData  as $TeamData ) {
            $TeamData['created_at'] = now();
            $TeamData['updated_at'] = now();
            DB::table('teams')->insertGetId($TeamData);
        }


    }
}


