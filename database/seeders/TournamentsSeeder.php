<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TournamentsSeeder extends Seeder
{
    public function run()
    {
        $TournamentsData  = [
            [
                'created_by' => 1,
                'name' => 'LE CUP',
                'start_date' => '2024-04-10',
                'end_date' => '2024-04-17',
                'is_completed' => false,
                'is_free' => true,
            ],
        ];

        foreach ($TournamentsData  as $TournamentData ) {
            $TournamentData['created_at'] = now();
            $TournamentData['updated_at'] = now();
            DB::table('tournaments')->insertGetId($TournamentData);
        }


    }
}


