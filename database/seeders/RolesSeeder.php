<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::pluck('id','id')->all();

        //Create Roles
        $roles=['Super Admin', 'Editor'];

        foreach($roles as $role){
            $role = Role::create(['name' => $role]);
            $role->syncPermissions($permissions);
        }
    }
}
