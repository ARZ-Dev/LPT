<?php

namespace Database\Seeders;

use App\Models\TournamentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TournamentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tournamentTypes = [
            'P100',
            'P250',
            'P500',
            'P1000',
        ];

        foreach ($tournamentTypes as $tournamentType) {
            TournamentType::updateOrCreate([
                'name' => $tournamentType,
            ]);
        }
    }
}
