<?php

namespace Database\Seeders;

use App\Models\KnockoutRound;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KnockoutRoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rounds = [
            [
                'name' => 'Round of 2048',
                'remaining_teams' => 2048
            ],
            [
                'name' => 'Round of 1024',
                'remaining_teams' => 1024
            ],
            [
                'name' => 'Round of 512',
                'remaining_teams' => 512
            ],
            [
                'name' => 'Round of 256',
                'remaining_teams' => 256
            ],
            [
                'name' => 'Round of 128',
                'remaining_teams' => 128
            ],
            [
                'name' => 'Round of 64',
                'remaining_teams' => 64
            ],
            [
                'name' => 'Round of 32',
                'remaining_teams' => 32
            ],
            [
                'name' => 'Round of 16',
                'remaining_teams' => 16
            ],
            [
                'name' => 'Quarter Final',
                'remaining_teams' => 8
            ],
            [
                'name' => 'Semi Final',
                'remaining_teams' => 4
            ],
            [
                'name' => 'Bronze Final',
                'remaining_teams' => 2
            ],
            [
                'name' => 'Final',
                'remaining_teams' => 2
            ],
        ];

        KnockoutRound::insert($rounds);
    }
}
