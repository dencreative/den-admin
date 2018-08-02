<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_users');
    }

    public function isSuperAdmin()
    {
        return $this->roles()->where('id','=','1');
    }

    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    public function addRole($role) {
        if (is_string($role))
            $role = Role::where('name', $role)->first();

        $this->roles()->attach($role);

    }

    public function removeRole($role) {
        if (is_string($role))
            $role = Role::where('name', $role)->first();

        $this->roles()->detatch($role);
    }

    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if($role->hasPermission($permission))
                return true;
        }
        return false;
    }
}
