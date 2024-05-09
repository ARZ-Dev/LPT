<?php

namespace Database\Factories;

use App\Models\LevelCategory;
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
        return [
            'nickname' => $this->faker->word, // Random nickname for the team
            'level_category_id' => 1, // Generate a level category using LevelCategory factory
        ];
    }
}
