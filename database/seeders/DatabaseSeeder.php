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
        $this->call(TillAmountSeeder::class);


        



        


        
    }
}
