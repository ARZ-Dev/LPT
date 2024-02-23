<?php

namespace Database\Seeders;

use App\Models\LevelCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levelCategories = [
            'Level A Men',
            'Level A Women',
            'Level B Men',
            'Level B Women',
            'Level C Men',
            'Level C Women',
            'Open Level Men',
            'Open Level Women',
            'Open Level Mix',
        ];

        foreach ($levelCategories as $levelCategory) {
            LevelCategory::updateOrCreate([
                'name' => $levelCategory
            ]);
        }
    }
}
