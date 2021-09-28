<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        return back();
    }

    public function update(UpdateUserRequest $request)
    {
        $this->authorize('user_update');

        DB::beginTransaction();

        $data = $request->validated();
        $role = Role::find($data['role']);

        try {
            $user = User::findOrFail($request->user_id);
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
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

                    if ($data->status == true && $data->is_approved == true) {
                        $status = '<span class="badge badge-success">Enabled</span> <span class="badge badge-success">Approved</span>';
                    } else if ($data->status == true && $data->is_approved == false) {
                        $status = '<span class="badge badge-success">Enabled</span> <span class="badge badge-warning">Pending</span>';
                    } else if ($data->status == false && $data->is_approved == true) {
                        $status = '<span class="badge badge-danger">Disabled</span> <span class="badge badge-success">Approved</span>';
                    } else {
                        $status = '<span class="badge badge-danger">Disabled</span> <span class="badge badge-warning">Pending</span>';
                    }

                    return $status;
                })
                ->addColumn('actions', function ($data) {
                    if($data->status == false && $data->is_approved == false) {
                        return
                        '<a href="javascript:void(0)" class="badge badge-success approveUser" data-id="' . $data->id . '">
                            <i class="fas fa-thumbs-up"></i> Aprove</a>
                        <a href="javascript:void(0)" class="badge badge-success enableUser" data-id="' . $data->id . '">
                            <i class="far fa-check-circle"></i> Enable</a>
                        <a href="javascript:void(0)" class="badge badge-info editUser" data-id="' . $data->id . '">
                            <i class="fas fa-user-edit"></i> Edit</a>
                        <a href="javascript:void(0)" class="badge badge-danger deleteUser" data-id="' . $data->id . '">
                            <i class="fas fa-user-minus"></i> Delete</a>';
                    } else if($data->status == 1 && $data->is_approved == 0) {
                        return
                        '<a href="javascript:void(0)" class="badge badge-success approveUser" data-id="' . $data->id . '">
                            <i class="fas fa-thumbs-up"></i> Aprove</a>
                        <a href="javascript:void(0)" class="badge badge-danger disableUser" data-id="' . $data->id . '">
                            <i class="fas fa-ban"></i> Disable</a>
                        <a href="javascript:void(0)" class="badge badge-danger deleteUser" data-id="' . $data->id . '">
                            <i class="fas fa-user-minus"></i> Delete</a>';
                    } else if($data->status == 0 && $data->is_approved == 1) {
                        return
                        '<a href="javascript:void(0)" class="badge badge-success enableUser" data-id="' . $data->id . '">
                            <i class="far fa-check-circle"></i> Enable</a>
                        <a href="javascript:void(0)" class="badge badge-danger deleteUser" data-id="' . $data->id . '">
                            <i class="fas fa-user-minus"></i> Delete</a>';
                    }
                    else {
                        return
                        '<a href="javascript:void(0)" class="badge badge-info editUser" data-id="' . $data->id . '">
                            <i class="fas fa-user-edit"></i> Edit</a>
                        <a href="javascript:void(0)" class="badge badge-danger disableUser" data-id="' . $data->id . '">
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

    public function approveUser(Request $request, $user_id)
    {
        $this->authorize('approve_user');

        if ($request->ajax()) {
            $user = User::findOrFail($user_id);
            $user->update([
                'is_approved' => true,
            ]);

            return response()->json('Success', 200);
        }
    }

    public function enableUser($user_id)
    {
        $this->authorize('enable_user');

        User::findOrFail($user_id)->update([
            'status' => true,
        ]);

        return response()->json(['success' => 'success'], 200);
    }

    public function disableUser($user_id)
    {
        $this->authorize('disable_user');

        User::findOrFail($user_id)->update([
            'status' => false,
        ]);

        return response()->json(['success' => 'success'], 200);
    }
}
