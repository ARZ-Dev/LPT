<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerTeamsSeeder extends Seeder
{
    public function run()
    {
        $PlayerTeamsData  = [
            [
                'player_id' => 1,
                'team_id' => 1,
                'playing_side'=> 'right',
            ],
            [
                'player_id' => 2,
                'team_id' => 2,
                'playing_side'=> 'left',
            ],
            [
                'player_id' => 3,
                'team_id' => 3,
                'playing_side'=> 'right',
            ],
            [
                'player_id' => 4,
                'team_id' => 4,
                'playing_side'=> 'left',
            ],
            [
                'player_id' => 5,
                'team_id' => 5,
                'playing_side'=> 'right',
            ],
            [
                'player_id' => 6,
                'team_id' => 6,
                'playing_side'=> 'left',
            ],
            [
                'player_id' => 7,
                'team_id' => 7,
                'playing_side'=> 'right',
            ],
            [
                'player_id' => 8,
                'team_id' => 8,
                'playing_side'=> 'left',
            ],
            [
                'player_id' => 9,
                'team_id' => 9,
                'playing_side'=> 'right',
            ],
            [
                'player_id' => 10,
                'team_id' => 10,
                'playing_side'=> 'left',
            ],
            [
                'player_id' => 11,
                'team_id' => 1,
                'playing_side'=> 'right',
            ],
            [
                'player_id' => 12,
                'team_id' => 2,
                'playing_side'=> 'left',
            ],
            [
                'player_id' => 13,
                'team_id' => 3,
                'playing_side'=> 'right',
            ],
            [
                'player_id' => 14,
                'team_id' => 4,
                'playing_side'=> 'left',
            ],
            [
                'player_id' => 15,
                'team_id' => 5,
                'playing_side'=> 'right',
            ],
            [
                'player_id' => 16,
                'team_id' =>6,
                'playing_side'=> 'left',
            ],
            [
                'player_id' => 17,
                'team_id' => 7,
                'playing_side'=> 'right',
            ],
            [
                'player_id' => 18,
                'team_id' => 8,
                'playing_side'=> 'left',
            ],
            [
                'player_id' => 19,
                'team_id' => 9,
                'playing_side'=> 'right',
            ],
            [
                'player_id' => 20,
                'team_id' => 10,
                'playing_side'=> 'left',
            ],

           
            
            
            
        ];

        foreach ($PlayerTeamsData  as $PlayerTeamData ) {

            DB::table('player_team')->insertGetId($PlayerTeamData);
        }


    }
}


