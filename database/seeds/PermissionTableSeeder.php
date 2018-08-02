<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    protected $permissions = [
        'roles_view' => 'View Roles',
        'roles_create' => 'Create Roles',
        'roles_update' => 'Assign Roles',
        'roles_delete' => 'Delete Roles',

        'users_view' => 'View Users',
        'users_create' => 'Create Users',
        'users_update' => 'Edit Users',
        'users_delete' => 'Delete Users',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->permissions as $key => $val) {
            $permission = new Permission();
            $permission->name = $key;
            if(isset($val) && $val !== '')
                $permission->display_name = $val;

            $permission->save();
        }
    }
}
