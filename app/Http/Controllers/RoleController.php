<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    ##-----------------------------------------------------------CONSTRUCT
    // public function __construct()
    // {
    //     $this->middleware('permission:role-list|role-create|role-edit|role-delete')->only(['index', 'store']);
    //     $this->middleware('permission:role-create')->only(['create', 'store']);
    //     $this->middleware('permission:role-edit')->only(['edit', 'update']);
    //     $this->middleware('permission:role-delete')->only(['destroy']);
    // }

    ##-----------------------------------------------------------INDEX
    public function index(Request $request)
    {
        $roles = Role::orderByDesc('id')->paginate(5);
        return view('roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    ##-----------------------------------------------------------CREATE
    public function create()
    {
        $permission = Permission::get();
        return view('roles.create', compact('permission'));
    }

    ##-----------------------------------------------------------STORE
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array',
        ]);

        $role = Role::create(['name' => $validatedData['name']]);
        $role->syncPermissions($validatedData['permission']);

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    ##-----------------------------------------------------------SHOW
    public function show($id)
    {
        $role = Role::findOrFail($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    ##-----------------------------------------------------------EDIT
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    ##-----------------------------------------------------------UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'permission' => 'required|array',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    ##-----------------------------------------------------------DELETE
    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
