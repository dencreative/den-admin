<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $role_admin  = Role::find(1);

        $admin = new User();
        $admin->name = 'Super Admin';
        $admin->email = 'super@admin.com';
        $admin->password = bcrypt('secret');
        $admin->save();
        $admin->roles()->attach($role_admin);
    }
}