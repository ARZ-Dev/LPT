<?php

namespace Database\Seeders;

use App\Models\TournamentDeuceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TournamentDeuceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deuceTypes = [
            'Short Deuce',
            'Full Deuce',
            '1 Deuce',
        ];

        foreach ($deuceTypes as $deuceType) {
            TournamentDeuceType::updateOrCreate([
                'name' => $deuceType,
            ]);
        }
    }
}
