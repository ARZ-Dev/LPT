<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TournamentLevelCategorySeeder extends Seeder
{
    public function run()
    {
        $TournamentLevelsCategoryData  = [
            [
                'tournament_id' => 1,
                'level_category_id' => 1,
                'has_group_stage' => 0,
                'start_date' => '2024-04-10',
                'end_date' => '2024-04-17',
                'is_group_matches_generated' => 0,
                'is_group_stages_completed' => 0,
                'is_knockout_matches_generated' => 0,
                'is_completed' => 0,
            ],
           
            
            
            
        ];

        foreach ($TournamentLevelsCategoryData  as $TournamentLevelCategoryData ) {
            $TournamentLevelCategoryData['created_at'] = now();
            $TournamentLevelCategoryData['updated_at'] = now();
            DB::table('tournament_level_categories')->insertGetId($TournamentLevelCategoryData);
        }


    }
}


