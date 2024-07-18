<?php

namespace Database\Factories;

use App\Models\LevelCategory;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $rank = 1; // Static variable to keep track of the rank within this factory

        return [
            'nickname' => "Team $rank",
            'level_category_id' => 1,
            'rank' => $rank++, // Increment the rank for each new instance
        ];
    }
}
