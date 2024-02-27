<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{

    public function run(): void
    {

        $permissions = Permission::pluck('id','id')->all();

        $users=[
            ['Super Admin','SA1','Super','Admin 1','sa1@lpt.com'],//Super Admin
            ['Super Admin','SA2','Super','Admin 2','sa2@lpt.com'],//Super Admin
            ['Super Admin','SA3','Super','Admin 3','sa3@lpt.com'],//Super Admin
            ['Editor','ED1','Editor','Editor 1','ed1@lpt.com'],//Editor
            ['Editor','ED2','Editor','Editor 2','ed2@lpt.com'],//Editor
            ['Editor','ED3','Editor','Editor 3','ed3@lpt.com'],//Editor
        ];

        foreach($users as $u){
            $user = User::create([
                'username' => $u[1],
                'first_name' => $u[2],
                'last_name' => $u[3],
                'email' => $u[4],
                'phone' => '000',
                'password' => Hash::make('secret')
            ]);
            $user->assignRole($u[0]);
        }
    }
}
