<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RoleTableSeeder extends Seeder {

    public function run()
    {
        $admin_role = new Role();
        $admin_role->name = 'admin';
        $admin_role->display_name = 'Administrator';
        $admin_role->save();
        $admin_role->permissions()->attach(Permission::all());

        $admin_role = new Role();
        $admin_role->name = 'user';
        $admin_role->display_name = 'User';
        $admin_role->save();
    }
}