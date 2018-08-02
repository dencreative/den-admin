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

        $roles = Role::all()->reject(function ($element){
            return $element->id === 1;
        });
        $users = User::all()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at->diffForHumans(),
                    'roles' => $user->roles,
                ];
            });

        return view('users.index', compact('users', 'roles'));
    }
}
