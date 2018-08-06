<?php

namespace App\Policies;

use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PlaybookPolicy
{
    use HandlesAuthorization;

    public function view()
    {
        return Auth::user()->hasPermission('playbooks_view');
    }

    public function create()
    {
        return Auth::user()->hasPermission('playbooks_create');
    }

    public function update()
    {
        return Auth::user()->hasPermission('playbooks_edit');
    }

    public function delete()
    {
        return Auth::user()->hasPermission('playbooks_delete');
    }

    public function restore()
    {
        return Auth::user()->isSuperAdmin();
    }

    public function forceDelete()
    {
        return Auth::user()->isSuperAdmin();
    }
}
