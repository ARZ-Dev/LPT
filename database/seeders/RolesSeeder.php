<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = Permission::pluck('id','id')->all();

        $roles=['Super Admin', 'Editor'];

        foreach($roles as $role){
            $role = Role::updateOrCreate(['name' => $role]);
            $role->syncPermissions($permissions);
        }
    }
}
