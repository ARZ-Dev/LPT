<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call(RolesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SubCategorySeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(TillSeeder::class);
        $this->call(LevelCategorySeeder::class);
        $this->call(TournamentTypeSeeder::class);
        $this->call(TournamentFormatSeeder::class);
        $this->call(TournamentDeuceTypeSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(GovernorateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(TillAmountSeeder::class);
        $this->call(TeamsSeeder::class);
        $this->call(PlayersSeeder::class);
        $this->call(TournamentsSeeder::class);
        $this->call(TournamentLevelCategorySeeder::class);
        $this->call(PlayerTeamsSeeder::class);
    }
}
