<?php

namespace Database\Seeders;

use App\Models\TournamentFormat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TournamentFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tournamentFormats = [
            'Multi Group Round Robin',
            'Knockout'
        ];

        foreach ($tournamentFormats as $tournamentFormat) {
            TournamentFormat::updateOrCreate([
                'name' => $tournamentFormat,
            ]);
        }
    }
}
