<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\UserManagementAccess\User\StoreUserRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('user_access');

        return view('users.index');
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('user_create');

        DB::beginTransaction();

        $data = $request->validated();

        //get role name
        $role = Role::find($data['role']);

        try {
            $user = User::firstOrCreate([
                'email' => $data['email'], // this will check if email exists in the database;
            ],[
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'user_type' => $role->name,
            ]);

            $user->assignRole($role->name);
            DB::commit();

            Alert::success('Success', 'User has been created.');
        }
        catch (Exception $ex) {
            DB::rollBack();
            throw $ex; // use better error handling, for now this will do;
        }

        return back();
    }

    public function destroy($id)
    {
        $this->authorize('user_delete');

        if (!empty($id)) {
            $deleteUser = User::find($id);
            $deleteUser->delete();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }

    public function usersList(Request $request)
    {
        $this->authorize('user_access');

        if ($request->ajax()) {

            $users = User::where('id','!=', auth()->user()->id)->get();

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('role', function ($data) {
                    return $data->getRoleNames();
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
                    if($data->status == 0 && $data->is_approved == 0) {
                        return
                        ' 
                        <td style="text-align: center; vertical-align: middle">
                            <a href="#" class="badge badge-success"
                                data-id="' . $data->id . '"
                                onclick="approveUser($(this))">
                                <i class="fas fa-thumbs-up"></i>
                                Aprove
                            </a>
                        </td>
                        <td style="text-align: center; vertical-align: middle">
                            <a href="#" class="badge badge-success"
                                data-id="' . $data->id . '"
                                onclick="enableUser($(this))">
                                <i class="far fa-check-circle"></i>
                                Enable
                            </a>
                        </td>
                        <td style="text-align: center; vertical-align: middle">
                            <a href="#" class="badge badge-danger"
                                data-id="' . $data->id . '"
                                onclick="deleteUser($(this))">
                                <i class="far fa-trash-alt"></i>
                                Delete
                            </a>
                        </td>
                        ';
                    } else if($data->status == 1 && $data->is_approved == 0) {
                        return
                        ' 
                        <td style="text-align: center; vertical-align: middle">
                            <a href="#" class="badge badge-success"
                                data-id="' . $data->id . '"
                                onclick="approveUser($(this))">
                                <i class="fas fa-thumbs-up"></i>
                                Aprove
                            </a>
                        </td>
                        <td style="text-align: center; vertical-align: middle">
                            <a href="#" class="badge badge-danger"
                                data-id="' . $data->id . '"
                                onclick="disableUser($(this))">
                                <i class="fas fa-ban"></i>
                                Disable
                            </a>
                        </td>
                        <td style="text-align: center; vertical-align: middle">
                            <a href="#" class="badge badge-danger"
                                data-id="' . $data->id . '"
                                onclick="deleteUser($(this))">
                                <i class="far fa-trash-alt"></i>
                                Delete
                            </a>
                        </td>
                        ';
                    } else if($data->status == 0 && $data->is_approved == 1) {
                        return
                        ' 
                        <td style="text-align: center; vertical-align: middle">
                            <a href="#" class="badge badge-success"
                                data-id="' . $data->id . '"
                                onclick="enableUser($(this))">
                                <i class="far fa-check-circle"></i>
                                Enable
                            </a>
                        </td>
                        <td style="text-align: center; vertical-align: middle">
                            <a href="#" class="badge badge-danger"
                                data-id="' . $data->id . '"
                                onclick="deleteUser($(this))">
                                <i class="far fa-trash-alt"></i>
                                Delete
                            </a>
                        </td>
                        ';
                    }

                    return
                    '
                    <td style="text-align: center; vertical-align: middle">
                        <a href="#" class="badge badge-danger"
                            data-id="' . $data->id . '"
                            onclick="disableUser($(this))">
                            <i class="fas fa-ban"></i>
                            Disabled
                        </a>
                    </td>
                    <td style="text-align: center; vertical-align: middle">
                        <a href="#" class="badge badge-danger"
                            data-id="' . $data->id . '"
                            onclick="deleteUser($(this))">
                            <i class="far fa-trash-alt"></i>
                            Delete
                        </a>
                    </td>
                    ';
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }
    }

    public function approveUser($id)
    {
        $this->authorize('approve_user');

        if (!empty($id)) {
            $approveUser = User::find($id);
            $approveUser->is_approve = true;
            $approveUser->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }

    public function enableUser($id)
    {
        $this->authorize('enable_user');

        if (!empty($id)) {
            $enableUser = User::find($id);
            $enableUser->status = true;
            $enableUser->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }

    public function disableUser($id)
    {
        $this->authorize('disable_user');

        if (!empty($id)) {
            $disableUser = User::find($id);
            $disableUser->status = false;
            $disableUser->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }
}
