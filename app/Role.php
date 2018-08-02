<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'roles_users');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_roles');
    }

    public function hasPermission($permission) {
        return $this->permissions()->get()->contains($permission);
//        return null !== $this->permissions()->where('name', $permission)->first();
    }
}
