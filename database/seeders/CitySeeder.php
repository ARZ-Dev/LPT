<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Koura', 'governorate_id' => 1],
            ['name' => 'Baabda', 'governorate_id' => 2],
            ['name' => 'Jbeil', 'governorate_id' => 3],
            ['name' => 'Nabatiyeh', 'governorate_id' => 4],
            ['name' => 'Sour', 'governorate_id' => 5],
            ['name' => 'Aakkar', 'governorate_id' => 6],
            ['name' => 'Batroun', 'governorate_id' => 1],
            ['name' => 'Bcharreh', 'governorate_id' => 1],
            ['name' => 'Aaley', 'governorate_id' => 2],
            ['name' => 'Saida', 'governorate_id' => 5],
            ['name' => 'Kesrouane', 'governorate_id' => 3],
            ['name' => 'Zgharta', 'governorate_id' => 1],
            ['name' => 'Marjaayoun', 'governorate_id' => 4],
            ['name' => 'Zahleh', 'governorate_id' => 7],
            ['name' => 'Baalbek', 'governorate_id' => 8],
            ['name' => 'Chouf', 'governorate_id' => 2],
            ['name' => 'Matn', 'governorate_id' => 2],
            ['name' => 'Beqaa Ouest', 'governorate_id' => 7],
            ['name' => 'Rachaiya', 'governorate_id' => 7],
            ['name' => 'Jezzine', 'governorate_id' => 5],
            ['name' => 'Minieh-Danniyeh', 'governorate_id' => 1],
            ['name' => 'Bent Jbeil', 'governorate_id' => 4],
            ['name' => 'Hasbaiya', 'governorate_id' => 4],
            ['name' => 'Hermel', 'governorate_id' => 8],
            ['name' => 'Beyrouth', 'governorate_id' => 9],
            ['name' => 'Tripoli', 'governorate_id' => 1],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
