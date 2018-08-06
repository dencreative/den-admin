<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    protected $permissions = [
        'roles_view' => 'View Roles',
        'roles_update' => 'Edit Roles',
        'roles_assign' => 'Assign Roles',

        'users_view' => 'View Users',

        'playbooks_view' => 'View Playbooks',
        'playbooks_create' => 'Create Playbooks',
        'playbooks_edit' => 'Edit Playbooks',
        'playbooks_delete' => 'Delete Playbooks',
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
