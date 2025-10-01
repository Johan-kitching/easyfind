<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        if (App::environment('local')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Role::truncate();
            Permission::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $roles = ['Super Admin', 'Admin', 'Personal', 'Operator', 'Company', 'User'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $permissions = array_unique([
            'Users - Create',
            'Admin Users - Edit',
            'Admin Users - Remove',
            'Admin Users - Activity',
            'Admin Users - API',
            'My Equipment - Add',
            'My Equipment - Edit',
            'My Equipment - Remove',
            'My Equipment - Rentals',
            'My Operators - Add',
            'My Machinery - Add',
            'Dashboard',
            'My Machinery',
            'My Equipment',
            'My Rentals',
            'My Operators',
            'Admin',
            'Admin Users',
            'Admin Permissions',
            'Admin Payment',
            'Admin Machinery',
            'Admin Machinery Type',
            'Admin Equipment',
            'Admin Equipment Type',
            'Admin Rentals'
        ]);
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
