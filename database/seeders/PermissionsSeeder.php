<?php

namespace Database\Seeders;

<<<<<<< HEAD
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
=======

>>>>>>> 9154491a58cbe5c3e5c8224a1b7d7230e479e1e5
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
<<<<<<< HEAD
    /**
     * Run the database seeds.
     */
=======

>>>>>>> 9154491a58cbe5c3e5c8224a1b7d7230e479e1e5
    public function run(): void
    {
        $permissions = [

            // Users Page
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            // Roles Page
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            // Permissions Page
            'permission-list',
<<<<<<< HEAD
            
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
=======
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
>>>>>>> 9154491a58cbe5c3e5c8224a1b7d7230e479e1e5
        }
    }
}
