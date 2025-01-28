<?php

namespace Database\Seeders;

use App\Models\SportCenter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SportCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sportCenters  = [
            [
                'name' => 'Sport Center 1',
                'country_id' => 123,
                'governorate_id' => 9,
                'city_id' => 25,
                'courts' => [
                    [
                        'name' => 'Court A',
                    ],
                    [
                        'name' => 'Court B',
                    ],
                ]
            ],
            [
                'name' => 'Sport Center 2',
                'country_id' => 123,
                'governorate_id' => 9,
                'city_id' => 25,
                'courts' => [
                    [
                        'name' => 'Court 1',
                    ],
                    [
                        'name' => 'Court 2',
                    ],
                ]
            ],
        ];

        foreach ($sportCenters as $center) {
            $sportCenter = SportCenter::create([
                'name' => $center['name'],
                'country_id' => $center['country_id'],
                'governorate_id' => $center['governorate_id'],
                'city_id' => $center['city_id'],
            ]);

            foreach ($center['courts'] as $court) {
                $sportCenter->courts()->create($court);
            }
        }
    }
}
