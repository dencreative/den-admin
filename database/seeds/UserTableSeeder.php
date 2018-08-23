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
        $admin->name = 'Admin 1';
        $admin->email = 'admin1@example.com';
        $admin->password = Hash::make('secret');
        $admin->save();
        $admin->addRole('Admin');

        $admin = new User();
        $admin->name = 'Admin 2';
        $admin->email = 'admin2@example.com';
        $admin->password = Hash::make('secret');
        $admin->save();
        $admin->addRole('Admin');

        $admin = new User();
        $admin->name = 'User 1';
        $admin->email = 'user1@example.com';
        $admin->password = Hash::make('secret');
        $admin->save();
        $admin->addRole('User');

        $admin = new User();
        $admin->name = 'User 2';
        $admin->email = 'user2@example.com';
        $admin->password = Hash::make('secret');
        $admin->save();
        $admin->addRole('User');

        $admin = new User();
        $admin->name = 'User 3';
        $admin->email = 'user3@example.com';
        $admin->password = Hash::make('secret');
        $admin->save();
        $admin->addRole('User');

        $admin = new User();
        $admin->name = 'User 4';
        $admin->email = 'user4@example.com';
        $admin->password = Hash::make('secret');
        $admin->save();
        $admin->addRole('User');
    }
}