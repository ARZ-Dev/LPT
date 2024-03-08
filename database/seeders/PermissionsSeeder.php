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
            'category-viewAll',

            'currency-list',
            'currency-create',
            'currency-edit',
            'currency-delete',
            'currency-viewAll',

            'till-list',
            'till-create',
            'till-edit',
            'till-delete',
            'till-viewAll',

            'payment-list',
            'payment-create',
            'payment-edit',
            'payment-delete',
            'payment-viewAll',

            'receipt-list',
            'receipt-create',
            'receipt-edit',
            'receipt-delete',
            'receipt-viewAll',

            'transfer-list',
            'transfer-create',
            'transfer-edit',
            'transfer-delete',
            'transfer-viewAll',

            'exchange-list',
            'exchange-create',
            'exchange-edit',
            'exchange-delete',
            'exchange-viewAll',

            'monthlyEntry-list',
            'monthlyEntry-create',
            'monthlyEntry-edit',
            'monthlyEntry-delete',
            'monthlyEntry-viewAll',

            'team-list',
            'team-create',
            'team-edit',
            'team-view',
            'team-delete',
            'team-viewAll',

            'player-list',
            'player-create',
            'player-edit',
            'player-view',
            'player-delete',
            'player-viewAll',
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
