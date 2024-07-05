<?php

namespace Database\Seeders;

use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governorates = [
            [
                'name' => 'Liban-Nord',
                'country_id' => 123,
            ],
            [
                'name' => 'Mont-Liban',
                'country_id' => 123,
            ],
            [
                'name' => 'Kesrouane Al Fatouh-Jbeil',
                'country_id' => 123,
            ],
            [
                'name' => 'Nabatiyeh',
                'country_id' => 123,
            ],
            [
                'name' => 'Liban-Sud',
                'country_id' => 123,
            ],
            [
                'name' => 'Aakkar',
                'country_id' => 123,
            ],
            [
                'name' => 'Beqaa',
                'country_id' => 123,
            ],
            [
                'name' => 'Baalbek-Hermel',
                'country_id' => 123,
            ],
            [
                'name' => 'Beyrouth',
                'country_id' => 123,
            ],
        ];

        foreach ($governorates as $governorate) {
            Governorate::create($governorate);
        }
    }
}
