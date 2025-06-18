<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->can('user.manage')) {
            return abort(403, 'Unauthorized');
        }

        try {
            $all_roles = Role::query()->orderBy('created_at', 'desc');

            $all_roles = $all_roles->paginate(2);

            if($request->ajax()){
                $data = view('backend.pages.role.showRoleList', compact('all_roles'))->render();
                return response()->json(['data' => $data]);
            }

            return view('backend.pages.role.index',compact('all_roles'));
        } catch (\Exception $th) {
            return response()->json([
                'atert_type' => 'error',
                'message'    => $th->getmessage(),
            ]);
        }
    }

    public function create(){
        if (!Auth::user()->can('user.create')) {
            return abort(403, 'Unauthorized');
        }

        $all_permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();

        return view('backend.pages.role.create', compact('all_permissions', 'permission_groups'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('user.create')) {
            return abort(403, 'Unauthorized');
        }

        // Validation Data
        $validate = $request->validate(
            [
                'name'      =>'required|max:100|unique:roles',
            ],
            [
                'name.required' => "Please Enter Role Name.",
                'name.max'      => "Role Name must not be greater than 100 characters",
                'name.unique'   => "This Role has already been taken."
            ]
        );
        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        $permissions = $request->input('permissions');
        if( !empty($permissions) ){
            $role->syncPermissions($permissions);
        }
        //return back();
        return redirect()->route('dashboard.role.index')->with('Role Created Successfully');
    }

    public function edit($id)
    {
        if (!Auth::user()->can('user.edit')) {
            return abort(403, 'Unauthorized');
        }

        $role = Role::find($id);

        if( !is_null($role) ){
            $all_permissions = Permission::all();
            $permission_groups = User::getpermissionGroups();

            return view('backend.pages.role.edit', compact('role','all_permissions','permission_groups'));
        }

    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('user.edit')) {
            return abort(403, 'Unauthorized');
        }
        // Validation Data
        $validate = $request->validate(
            [
                'name'      =>'required|max:100|unique:roles,name,'.$id,
            ],
            [
                'name.required' => "Please Enter Role Name.",
                'name.max'      => "Role Name must not be greater than 100 characters.",
                'name.unique'   => "This Role has already been taken."
            ]
        );

        $role = Role::find($id);

        $permissions = $request->input('permissions');
        if( !empty($permissions) ){
            $role->name = $request->name;
            $role->guard_name = 'web';
            $role->save();

            $role->syncPermissions($permissions);
        }

        return redirect()->route('dashboard.role.index')->with('Role Updated Successfully');
    }
}
