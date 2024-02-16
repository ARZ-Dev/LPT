<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
            
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
