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
<<<<<<< HEAD



=======
>>>>>>> fccc9d47a8e9bdf9ecd9100dedcd2f035d51bdb2
    }
}
