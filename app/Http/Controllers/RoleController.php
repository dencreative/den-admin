<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('roles.index', compact('roles','permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $this->validate($request, [
            'permission_id' => 'required'
        ]);

        $role->permissions()->toggle($request->permission_id);

        return response()->json(['success']);
    }

}
