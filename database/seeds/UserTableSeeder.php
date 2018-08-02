<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $admin = new User();
        $admin->name = 'Super Admin';
        $admin->email = 'super@admin.com';
        $admin->password = Hash::make('secret');
        $admin->save();
        $admin->addRole(Role::getSuperAdmin());

        $admin = new User();
        $admin->name = 'Admin Example';
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('secret');
        $admin->save();
        $admin->addRole('Admin');

        $admin = new User();
        $admin->name = 'User Example';
        $admin->email = 'user@example.com';
        $admin->password = Hash::make('secret');
        $admin->save();
        $admin->addRole('User');
    }
}