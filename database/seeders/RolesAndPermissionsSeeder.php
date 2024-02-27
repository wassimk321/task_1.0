<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        // Permission::findOrCreate('Settings');

        $role = Role::findOrCreate('Admin');
        $role = Role::findOrCreate('User');

        // $role->givePermissionTo(Permission::all());
    }
}
