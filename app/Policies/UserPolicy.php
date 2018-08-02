<?php

namespace App\Policies;

use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    public function view()
    {
        return Auth::user()->hasPermission('users_view');
    }

    public function create(User $user)
    {
        return Auth::user()->hasPermission('users_create');
    }

    public function update(User $user)
    {
        return Auth::user()->hasPermission('users_update');
    }

    public function delete(User $user)
    {
        return Auth::user()->hasPermission('users_delete');
    }

    public function restore(User $user, Role $role)
    {
        return Auth::user()->isSuperAdmin();
    }

    public function forceDelete()
    {
        return Auth::user()->isSuperAdmin();
    }
}
