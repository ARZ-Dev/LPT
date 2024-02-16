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
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = Permission::pluck('id','id')->all();

        $users=[
            ['1','SA1','Super','Admin','sa1@padel.com'],//Super Admin
            ['1','SA2','Super','Admin','sa2@padel.com'],//Super Admin
            ['1','SA3','Super','Admin','sa3@padel.com'],//Super Admin
            ['2','ED1','Editor','Editor','ed1@padel.com'],//Editor
            ['2','ED2','Editor','Editor','ed2@padel.com'],//Editor
            ['2','ED3','Editor','Editor','ed3@padel.com'],//Editor
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
            // $user->assignRole($u[0]);
            Role::firstOrCreate(['name' => $u[0], 'guard_name' => 'web']);
        }
    }
}
