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
            'user-view',
            'user-viewAll',
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
            'category-view',
            'category-delete',
            'category-viewAll',

            'currency-list',
            'currency-create',
            'currency-edit',
            'currency-view',
            'currency-delete',
            'currency-viewAll',

            'till-list',
            'till-create',
            'till-edit',
            'till-view',
            'till-delete',
            'till-viewAll',

            'payment-list',
            'payment-create',
            'payment-edit',
            'payment-view',
            'payment-delete',
            'payment-viewAll',

            'receipt-list',
            'receipt-create',
            'receipt-edit',
            'receipt-view',
            'receipt-delete',
            'receipt-viewAll',

            'transfer-list',
            'transfer-create',
            'transfer-edit',
            'transfer-view',
            'transfer-delete',
            'transfer-viewAll',

            'exchange-list',
            'exchange-create',
            'exchange-edit',
            'exchange-view',
            'exchange-delete',
            'exchange-viewAll',

            'monthlyEntry-list',
            'monthlyEntry-create',
            'monthlyEntry-edit',
            'monthlyEntry-view',
            'monthlyEntry-delete',
            'monthlyEntry-viewAll',

            'pettyCashSummary-view',

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

            'tournament-list',
            'tournament-create',
            'tournament-edit',
            'tournament-view',
            'tournament-delete',
            'tournament-viewAll',
            'tournament-setSubscriptionFees',
            'tournament-categories',

            'tournamentCategory-edit',
            'tournamentCategory-delete',
            'tournamentCategory-generateMatches',
            'tournamentCategory-stages',
            'tournamentCategory-stagesSettings',
            'tournamentCategory-knockoutMap',

            'matches-list',
            'matches-view',
            'matches-scoring',
            'matches-setDate',


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
