<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Player;
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
        static $maleRank = 1;
        static $femaleRank = 1;
        static $counter = 1;

        $gender = $this->faker->randomElement(['male', 'female']);

        if ($gender == "male") {
            $rank = $maleRank++;
        } else {
            $rank = $femaleRank++;
        }

        return [
            'first_name' => "Player",
            'middle_name' => "",
            'last_name' => $counter++,
            'birthdate' => $this->faker->date('Y-m-d', '2003-01-01'), // Adjust the birthdate range as needed
            'email' => $this->faker->optional()->safeEmail, // Optional field
            'phone_number' => $this->faker->phoneNumber,
            'national_id_upload' => null, // Assuming you want this to be null initially
            'country_id' => 123, // Generate a country using the Country factory
            'nickname' => $this->faker->word, // Generate a random nickname
            'playing_side' => $this->faker->randomElement(['left', 'right']), // Assuming playing side can be 'left' or 'right'
            'rank' => $rank,
            'gender' => $gender,
        ];
    }
}
