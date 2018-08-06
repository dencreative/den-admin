<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('view', User::class);

        $roles = Role::all()->except(Role::getSuperAdmin()->id);
        $users = User::all()
            ->except([1])
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at->diffForHumans(),
                    'roles' => $user->roles->pluck('id')->all(),
                ];
            });

        return view('users.index', compact('users', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate($request, [
            'role_id' => 'required'
        ]);

        $user->roles()->toggle($request->role_id);

        return response()->json(['success' => 'Role toggled']);
    }

}
