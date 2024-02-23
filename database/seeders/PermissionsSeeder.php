<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionsSeeder extends Seeder
{
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

            'category-list',
            'category-create',
            'category-edit',
            'category-delete',

            'currency-list',
            'currency-create',
            'currency-edit',
            'currency-delete',

            'till-list',
            'till-create',
            'till-edit',
            'till-delete',

            'payment-list',
            'payment-create',
            'payment-edit',
            'payment-delete',

            'receipt-list',
            'receipt-create',
            'receipt-edit',
            'receipt-delete',

            'transfer-list',
            'transfer-create',
            'transfer-edit',
            'transfer-delete',

        ];

        $permissionsIds = [];
        foreach ($permissions as $permission) {
            $createdPermission = Permission::updateOrCreate(['name' => $permission]);
            $permissionsIds[] = $createdPermission->id;
        }
        
        $adminRole = Role::find(1);
        if($adminRole!=null){
            $adminRole->syncPermissions($permissionsIds);
        }
    }
}
