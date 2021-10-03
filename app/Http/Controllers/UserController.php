<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\UserManagementAccess\User\StoreUserRequest;
use App\Http\Requests\UserManagementAccess\User\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('user_access');

        return view('users.index');
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('user_create');

        DB::beginTransaction();

        $data = $request->validated();
        $role = Role::find($data['role']);

        try {
            $user = User::firstOrCreate([
                'email' => $data['email'], // this will check if email exists in the database;
            ],[
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $user->assignRole($role->name);

            DB::commit();
            Alert::success('Success', 'User has been created.');
        }
        catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect()->route('users.index');
    }

    public function update(UpdateUserRequest $request)
    {
        $this->authorize('user_update');

        DB::beginTransaction();

        $data = $request->validated();
        $role = Role::find($data['role']);

        try {
            $user = User::findOrFail($request->user_id);

            if($request->filled('password')) {
                $user->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);
            }
            else {
                $user->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                ]);
            }
            $user->removeRole($user->roles->first());
            $user->assignRole($role->name);

            DB::commit();
            alert()->success('Success', 'User credentials has been updated.');
        }
        catch (\Throwable $th) {
            DB::rollBack();
        }

        return back();
    }

    public function destroy($user_id)
    {
        $this->authorize('user_delete');

        User::findOrFail($user_id)->delete();

        return response()->json(['success' => 'success'], 200);
    }

    public function usersList(Request $request)
    {
        $this->authorize('user_access');

        if ($request->ajax()) {

            $users = User::where('id','!=', auth()->user()->id)->get();

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('role', function ($data) {
                    return '<span class="badge badge-light">' . $data->getRoleNames() . '</span>';
                })
                ->addColumn('status', function ($data) {

                    if ($data->status == 1 && $data->is_approved == 1) {
                        $status = '<span class="badge badge-success">Enabled</span> <span class="badge badge-success">Approved</span>';
                    } else if ($data->status == 1 && $data->is_approved == 0) {
                        $status = '<span class="badge badge-success">Enabled</span> <span class="badge badge-light">Pending for Approval</span>';
                    } else if ($data->status == 0 && $data->is_approved == 1) {
                        $status = '<span class="badge badge-danger">Account Disabled</span> <span class="badge badge-success">Approved</span>';
                    } else {
                        $status = '<span class="badge badge-danger">Account Disabled</span> <span class="badge badge-light">Pending for Approval</span>';
                    }

                    return $status;
                })
                ->addColumn('actions', function ($data) {
                    if($data->status == 0 && $data->is_approved == 0) {
                        return
                        '<a href="javascript:void(0)" class="badge badge-success approveUser" data-id="' . $data->id . '" onclick="approveUser($(this))">
                            <i class="fas fa-thumbs-up"></i> Aprove</a>
                        <a href="javascript:void(0)" class="badge badge-success enableUser" data-id="' . $data->id . '" onclick="enableUser($(this))">
                            <i class="far fa-check-circle"></i> Enable</a>
                        <a href="javascript:void(0)" class="badge badge-danger deleteUser" data-id="' . $data->id . '">
                            <i class="fas fa-user-minus"></i> Delete</a>';
                    } else if($data->status == 1 && $data->is_approved == 0) {
                        return
                        '<a href="javascript:void(0)" class="badge badge-success approveUser" data-id="' . $data->id . '" onclick="approveUser($(this))">
                            <i class="fas fa-thumbs-up"></i> Aprove</a>
                        <a href="javascript:void(0)" class="badge badge-danger disableUser" data-id="' . $data->id . '" onclick="disableUser($(this))">
                            <i class="fas fa-ban"></i> Disable</a>
                        <a href="javascript:void(0)" class="badge badge-danger deleteUser" data-id="' . $data->id . '">
                            <i class="fas fa-user-minus"></i> Delete</a>';
                    } else if($data->status == 0 && $data->is_approved == 1) {
                        return
                        '<a href="javascript:void(0)" class="badge badge-success enableUser" data-id="' . $data->id . '" onclick="enableUser($(this))">
                            <i class="far fa-check-circle"></i> Enable</a>
                        <a href="javascript:void(0)" class="badge badge-danger deleteUser" data-id="' . $data->id . '">
                            <i class="fas fa-user-minus"></i> Delete</a>';
                    }
                    else {
                        return
                        '<a href="javascript:void(0)" class="badge badge-info editUser" data-id="' . $data->id . '">
                            <i class="fas fa-user-edit"></i> Edit</a>
                        <a href="javascript:void(0)" class="badge badge-danger disableUser" data-id="' . $data->id . '" onclick="disableUser($(this))">
                            <i class="fas fa-ban"></i> Disable</a>
                        <a href="javascript:void(0)" class="badge badge-danger deleteUser" data-id="' . $data->id . '">
                            <i class="fas fa-user-minus"></i> Delete</a>';
                    }
                })
                ->rawColumns(['role', 'status', 'actions'])
                ->make(true);
        }
    }

    public function userDetails($user_id)
    {
        $this->authorize('user_access');

        $user = User::with(['roles' => function ($query) {
                    $query->select('id', 'name');
                }])->findOrFail($user_id);
                
        return response()->json($user);
    }

    public function approveUser($id)
    {
        if (!empty($id)) {
            $user = User::find($id);
            $user->is_approved = 1;
            $user->markEmailAsVerified();
            $user->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }

    public function enableUser($id)
    {
        if (!empty($id)) {
            $user = User::find($id);
            $user->status = 1;
            $user->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }

    public function disableUser($id)
    {
        if (!empty($id)) {
            $user = User::find($id);
            $user->status = 0;
            $user->email_verified_at = NULL;
            $user->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }
}
