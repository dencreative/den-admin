<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RoleTableSeeder extends Seeder {

    public function run()
    {
        $super_admin_role = new Role();
        $super_admin_role->name = 'Super-Admin';
        $super_admin_role->save();
        $super_admin_role->permissions()->attach(Permission::all());

        $admin_role = new Role();
        $admin_role->name = 'Admin';
        $admin_role->save();
        $admin_role->permissions()->attach(Permission::all());

        $default_role = new Role();
        $default_role->name = 'User';
        $default_role->save();
    }
}