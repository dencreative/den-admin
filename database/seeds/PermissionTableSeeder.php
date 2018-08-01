<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    protected $permissions = [
        'roles_create' => [],
        'roles_read' => [],
        'roles_update' => [],
        'roles_delete' => [],

        'users_create' => [],
        'users_delete' => [],
        'users_edit' => [],
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
            if(array_key_exists('display_name', $val))
                $permission->display_name = $val['display_name'];

            $permission->save();
        }
    }
}
