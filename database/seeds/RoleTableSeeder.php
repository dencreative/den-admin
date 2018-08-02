<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RoleTableSeeder extends Seeder {

    public function run()
    {
        $superAdmin = new Role();
        $superAdmin->name = 'Super Admin';
        $superAdmin->save();
        $superAdmin->permissions()->attach(Permission::all());

        $admin_role = new Role();
        $admin_role->name = 'Admin';
        $admin_role->save();
        $admin_role->permissions()->attach(Permission::all());

        $default_role = new Role();
        $default_role->name = 'User';
        $default_role->save();
    }
}