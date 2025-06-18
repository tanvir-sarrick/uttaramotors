<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->can('permission.manage')) {
            return abort(403, 'Unauthorized');
        }

        try {
            $permission_groups = User::getpermissionGroups();
            $all_permissions = Permission::query()->orderBy('created_at', 'desc');

            $all_permissions = $all_permissions->get();
            if($request->ajax()){
                $data = view('backend.pages.permission.showPermissionList', compact('all_permissions', 'permission_groups'))->render();
                return response()->json(['data' => $data]);
            }

            return view('backend.pages.permission.index',compact('all_permissions', 'permission_groups'));
        } catch (\Exception $th) {
            return response()->json([
                'atert_type' => 'error',
                'message'    => $th->getmessage(),
            ]);
        }
    }

    public function create()
    {
        if (!Auth::user()->can('permission.create')) {
            return abort(403, 'Unauthorized');
        }
        return view('backend.pages.permission.create');
    }


    public function store(Request $request)
    {
        if (!Auth::user()->can('permission.create')) {
            return abort(403, 'Unauthorized');
        }
        // Validation Data
        // $validate = $request->validate(
        //     [
        //         'group_name'          =>'required|max:30',
        //         'name' => 'required',
        //     ],
        //     [
        //         'group_name.required' => "Please Enter Group Name.",
        //         //'name.required'       => "Please Enter Permission Name.",
        //         'group_name.max'      => "Group Name must not be greater than 30 characters",
        //         //'name.max'            => "Permission Name must not be greater than 50 characters",
        //     ]
        // );
        $countPermission = count($request->name)-1;
         //dd($countPermission);
        if ( $countPermission  !== 0){
            for ( $i=0; $i <$countPermission; $i++ ){
                $permission_new                 = new Permission();
                $permission_new->group_name     = $request->group_name;
                $permission_new->guard_name     = 'web';
                $permission_new->name           = $request->name[$i];
                $permission_new->save();
            }
            return redirect()->route('dashboard.permission.index')->with('Permission Created Successfully');
        }
        else {
            dd('error notification');
        }
    }

    public function edit($group_name)
    {
        if (!Auth::user()->can('permission.edit')) {
            return abort(403, 'Unauthorized');
        }
        $all_permission = Permission::select('name')->where('group_name', $group_name)->get();
        //dd($all_permission);
        return view('backend.pages.permission.edit', compact('all_permission', 'group_name'));
    }

    public function update(Request $request, $group_name)
    {
        $permission = Permission::select('group_name')->where('group_name', $group_name)->groupBy('group_name')->get();

        if ( $permission[0]['group_name'] == $group_name){
            //dd($group_name);
            $countPermission = count($request->name)-1;
            //dd($countPermission);

            // if ( $countPermission != NULL ){
                Permission::where('group_name', $group_name)->delete();
                for ( $i=0; $i < $countPermission; $i++ ){
                    $permission_new                 = new Permission();

                    $permission_new->group_name     = $request->group_name;
                    $permission_new->name           = $request->name[$i];
                    $permission_new->guard_name     = 'web';
                    $permission_new->save();


                }
                return redirect()->route('dashboard.permission.index')->with('Permission Updated Successfullt');
            //}
            //dd($permission);
        }
    }

    public function destroy(Request $request, $group_name)
    {
        if (!Auth::user()->can('permission.delete')) {
            return abort(403, 'Unauthorized');
        }

        $permissions  = Permission::where('group_name', $group_name)->get();
        //dd($permissions);
        if (!is_null($permissions) && $permissions->isNotEmpty())
        {
        // Loop through each permission and delete it along with related roles
        foreach ($permissions as $permission) {
            $permission->roles()->detach(); // Remove related roles
            $permission->delete(); // Delete the permission
        }
            return response()->json([
                'success' => true,
                'status' => 'warning',
                "message" => "Permissions and related roles deleted successfully.",
                "url" => route('dashboard.permission.index')
            ]);
        }

        else {
            return response()->json([
                'status' => 'warning',
                "message" => "No permissions found for the specified group name.",
            ]);
        }
    }
}
