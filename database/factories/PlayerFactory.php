<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->firstName, // Optional field
            'last_name' => $this->faker->lastName,
            'birthdate' => $this->faker->date('Y-m-d', '2003-01-01'), // Adjust the birthdate range as needed
            'email' => $this->faker->optional()->safeEmail, // Optional field
            'phone_number' => $this->faker->phoneNumber,
            'national_id_upload' => null, // Assuming you want this to be null initially
            'country_id' => 123, // Generate a country using the Country factory
            'nickname' => $this->faker->word, // Generate a random nickname
            'playing_side' => $this->faker->randomElement(['left', 'right']), // Assuming playing side can be 'left' or 'right'
        ];
    }
}
