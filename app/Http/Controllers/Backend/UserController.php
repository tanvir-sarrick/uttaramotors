<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->can('user.manage')) {
            return abort(403, 'Unauthorized');
        }

        try {
            $users = User::query()->orderBy('created_at', 'desc');

            $users = $users->paginate(2);

            if($request->ajax()){
                $data = view('backend.pages.user.showUserList', compact('users'))->render();
                return response()->json(['data' => $data]);
            }

            return view('backend.pages.user.index',compact('users'));
        } catch (\Exception $th) {
            return response()->json([
                'atert_type' => 'error',
                'message'    => $th->getmessage(),
            ]);
        }
    }

    public function create()
    {
        if (!Auth::user()->can('user.create')) {
            return abort(403, 'Unauthorized');
        }

        $all_roles = Role::all();
        return view('backend.pages.user.create', compact('all_roles'));
    }
    public function store(Request $request)
    {
        if (!Auth::user()->can('user.create')) {
            return abort(403, 'Unauthorized');
        }
        // Validation Data
        $validate = $request->validate(
            [
                'name'          =>'required|max:100',
                'email'         =>'required|email|unique:users',
                'password'      =>'required|min:8',
                'roles'         =>'required',
            ],
            [
                'name.required' => "Please Enter User Name.",
                'name.max'      => "User Name must not be greater than 100 characters",
                'email.unique'   => "This Email has already been taken.",
            ]
        );

        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();
        if( $request->roles ){
            $user->assignRole($request->roles);
        }
        // dd($user);exit();
        return redirect()->route('dashboard.user.index')->with('User Created Successfully.');
    }

    public function edit($id)
    {
        if (!Auth::user()->can('user.edit')) {
            return abort(403, 'Unauthorized');
        }

        $user = User::find($id);

        if( !is_null($user) ){
            $all_roles = Role::all();
            return view('backend.pages.user.edit', compact('all_roles','user'));
        }
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('user.edit')) {
            return abort(403, 'Unauthorized');
        }

        $user   = User::find($id);
        if( !is_null($user) ){
            // Validation Data
            $validate = $request->validate(
                [
                    'name'          =>'required|max:100',
                    'email'         =>'required|email|unique:users,email,'.$id,
                    'roles'         =>'required',
                ],
                [
                    'name.required' => "Please Enter User Name.",
                    'name.max'      => "User Name must not be greater than 100 characters",
                ]
            );

            $user->name         = $request->name;
            $user->email        = $request->email;


            $user->save();
            $user->roles()->detach();
            if( $request->roles ){
                $user->assignRole($request->roles);
            }
             //dd($user);exit();
             return redirect()->route('dashboard.user.index');
        }
    }

    public function destroy(Request $request, $id)
    {
        if (!Auth::user()->can('user.delete')) {
            return abort(403, 'Unauthorized');
        }

        $user = User::find($id);
        //dd($user);
        if( !is_null($user) ){
           $user->delete();

           if($user->delete()){
                $user->syncRoles([]);
                $user->syncPermissions([]);
           }
            return response()->json([
                'success' => true,
                'status' => 'success',
                "message" => "User deleted successfully.",
                "url" => route('dashboard.user.index')
            ]);
        }
        else{
            return response()->json([
                "message" => "No User found for the specified ID.",
                "url" => route('dashboard.user.index')
            ]);
        }
    }
}
