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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->can('user.manage')) {
            return abort(403, 'Unauthorized');
        }

        try {
            $users = User::query()->orderBy('created_at', 'desc')->paginate(2);

            return view('backend.pages.user.index',compact('users'));
        } catch (\Exception $th) {
            return response()->json([
                'atert_type' => 'error',
                'message'    => $th->getmessage(),
            ]);
        }
    }

    public function loadMoreUser(Request $request)
    {
        try {
            $query = User::orderBy('created_at', 'desc');

            if ($request->filled('filterData')) {
                $data = $request->input('filterData');
                $query->where(fn($q) => $q
                    ->where('name', 'like', "%$data%")
                    ->orWhere('email', 'like', "%$data%")
                );
            }

            if ($request->filled('status')) {
                $status = (int) $request->input('status');

                if ($status !== 2) {
                    $query->where('status', $status);
                }
            }

            $users = $query->paginate(2);

            $data = view('backend.pages.user.showUserList', compact('users'))->render();

            return response()->json([
                'data' => $data,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'alert_type' => 'error',
                'message'    => $e->getMessage(),
            ]);
        }
    }

    public function filterUserData(Request $request)
    {
        try {
            $query = User::orderBy('created_at', 'desc');

            if ($request->filled('filterData')) {
                $data = $request->input('filterData');
                $query->where(fn($q) => $q
                    ->where('name', 'like', "%$data%")
                    ->orWhere('email', 'like', "%$data%")
                );
            }

            if ($request->filled('status')) {
                $status = (int) $request->input('status');

                if ($status !== 2) {
                    $query->where('status', $status);
                }
            }

            $users = $query->paginate(2);

            $data = view('backend.pages.user.showUserList', compact('users'))->render();

            return response()->json([
                'data' => $data,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'alert_type' => 'error',
                'message'    => $e->getMessage(),
            ]);
        }
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->can('user.create')) {
            return abort(403, 'Unauthorized');
        }

        $all_roles = Role::all();
        return view('backend.pages.user.create', compact('all_roles'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->can('user.create')) {
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
        $user->status     = $request->status;

        $user->save();
        if( $request->roles ){
            $user->assignRole($request->roles);
        }
        // dd($user);exit();
        return redirect()->route('dashboard.user.index')->with('success', 'User Created Successfully.');
    }

    public function edit($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->can('user.edit')) {
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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->can('user.edit')) {
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
            $user->status     = $request->status;

            $user->save();
            $user->roles()->detach();
            if( $request->roles ){
                $user->assignRole($request->roles);
            }

            return redirect()->route('dashboard.user.index')->with('success', 'User updated successfully.');
        }
    }

    public function destroy(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->can('user.delete')) {
            return abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);
        //dd($user);
        if( !is_null($user) ){
           if ($user->status === 1) {
            $status = 0;
            $user->update([
                'status' => $status,
            ]);

            return response()->json([
                'success' => true,
                'status' => 'success',
                "message" => "This user has been softdeleted successfully",
            ]);
            }else{
                return response()->json([
                    'success' => true,
                    'status' => 'warning',
                    "message" => "This user has already been softdeleted!",
                ]);
            }
        }
        else{
            return response()->json([
                "message" => "No user found for the specified ID.",
            ]);
        }
    }
}
