<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamPlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed 64 players
        $players = Player::factory()->count(64)->create();

        // Seed 32 teams
        $teams = Team::factory()->count(32)->create();

        // Attach 2 players to each team
        $playersPerTeam = 2;

        foreach ($teams as $team) {
            // Select 2 random players and attach them to the team
            $randomPlayers = $players->random($playersPerTeam);
            // Attach each player to the team with a specified playing_side
            foreach ($randomPlayers as $player) {
                // Randomly assign 'left' or 'right' playing_side
                $team->players()->attach($player->id, ['playing_side' => "right"]);
            }
        }
    }
}
