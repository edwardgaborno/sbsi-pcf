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
use App\Models\Department;
use App\Models\ProductSegment;
use App\Models\UserProductSegment;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('user_access');
        $productSegments = ProductSegment::where('is_active', 1)->orderBy('product_segment', 'ASC')->get();
        $departments = Department::where('is_active', 1)->orderBy('department', 'ASC')->get();

        return view('users.index', [
            'productSegments' => $productSegments,
            'departments' => $departments
        ]);
    }

    public function create()
    {
        $productSegments = ProductSegment::where('is_active', 1)->orderBy('product_segment', 'ASC')->get();
        $departments = Department::where('is_active', 1)->orderBy('department', 'ASC')->get();

        return view('users.create', [
            'productSegments' => $productSegments,
            'departments' => $departments
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('user_create');
        DB::beginTransaction();

        $data = $request->validated();
        $role = Role::find($data['role']);

        try {
            $saveUser = new User;
            $saveUser->name = $request->name;
            $saveUser->email = $request->email;
            $saveUser->password = Hash::make($request->password);
            $saveUser->department_id = $request->department_id;

            if ($request->area_region) {
                $saveUser->area_region = $request->area_region;
            }

            if ($request->product_segment_id) {
                foreach ($request->product_segment_id as $productSegmentId) {
                    $saveProductSegment = new UserProductSegment;
                    $saveProductSegment->user_id = $saveUser->id;
                    $saveProductSegment->product_segment_id = $productSegmentId;
                    $saveProductSegment->save();
                }
            }

            $saveUser->save();
            $saveUser->assignRole($role->name);

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
            $updateUser = User::findOrFail($request->user_id);
            $updateUser->name = $request->name;
            $updateUser->email = $request->email;
            $updateUser->department_id = $request->department_id;

            if ($request->password) {
                $updateUser->password = Hash::make($request->password);
            }

            if ($request->area_region) {
                $updateUser->area_region = $request->area_region;
            }

            $updateUser->save();

            if ($request->product_segment_id) {
                //delete old SBU records 
                UserProductSegment::where('user_id', $request->user_id)->delete();
                //save new SBU records
                foreach ($request->product_segment_id as $productSegmentId) {
                    $saveProductSegment = new UserProductSegment;
                    $saveProductSegment->user_id = $updateUser->id;
                    $saveProductSegment->product_segment_id = $productSegmentId;
                    $saveProductSegment->save();
                }
            } else {
                //if user unchecked all SBU
                //delete all SBU records
                UserProductSegment::where('user_id', $request->user_id)->delete();
            }

            $updateUser->removeRole($updateUser->roles->first());
            $updateUser->assignRole($role->name);

            DB::commit();
            alert()->success('Success', 'User account has been updated.');
        }
        catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect()->route('users.index');
    }

    public function usersList(Request $request)
    {
        $this->authorize('user_access');

        if ($request->ajax()) {

            $users = User::where('id','!=', auth()->user()->id)->get();

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('role', function ($data) {
                    return '<span class="btn btn-sm btn-light">' . $data->getRoleNames() . '</span>';
                })
                ->addColumn('department', function ($data) {
                    return $data->departments->department;
                })
                ->addColumn('status', function ($data) {

                    if ($data->status == 1 && $data->is_approved == 1) {
                        $status = '<span class="btn btn-sm btn-success">Enabled</span> <span class="btn btn-sm btn-success">Approved</span>';
                    } else if ($data->status == 1 && $data->is_approved == 0) {
                        $status = '<span class="btn btn-sm btn-success">Enabled</span> <span class="btn btn-sm btn-light">Pending for Approval</span>';
                    } else if ($data->status == 0 && $data->is_approved == 1) {
                        $status = '<span class="btn btn-sm btn-danger">Account Disabled</span> <span class="btn btn-sm btn-success">Approved</span>';
                    } else {
                        $status = '<span class="btn btn-sm btn-danger">Account Disabled</span> <span class="btn btn-sm btn-light">Pending for Approval</span>';
                    }

                    return $status;
                })
                ->addColumn('actions', function ($data) {
                    if($data->status == 0 && $data->is_approved == 0) {
                        return
                        '<a href="javascript:void(0)" class="btn btn-sm btn-success approveUser" data-id="' . $data->id . '" onclick="approveUser($(this))">
                            <i class="fas fa-thumbs-up"></i> Aprove</a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-success enableUser" data-id="' . $data->id . '" onclick="enableUser($(this))">
                            <i class="far fa-check-circle"></i> Enable</a>';
                    } else if($data->status == 1 && $data->is_approved == 0) {
                        return
                        '<a href="javascript:void(0)" class="btn btn-sm btn-success approveUser" data-id="' . $data->id . '" onclick="approveUser($(this))">
                            <i class="fas fa-thumbs-up"></i> Aprove</a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger disableUser" data-id="' . $data->id . '" onclick="disableUser($(this))">
                            <i class="fas fa-ban"></i> Disable</a>';
                    } else if($data->status == 0 && $data->is_approved == 1) {
                        return
                        '<a href="javascript:void(0)" class="btn btn-sm btn-success enableUser" data-id="' . $data->id . '" onclick="enableUser($(this))">
                            <i class="far fa-check-circle"></i> Enable</a>';
                    }
                    else {
                        return
                        '<a href="javascript:void(0)" class="btn btn-sm btn-info editUser" data-id="' . $data->id . '">
                            <i class="fas fa-user-edit"></i> Edit</a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger disableUser" data-id="' . $data->id . '" onclick="disableUser($(this))">
                            <i class="fas fa-ban"></i> Disable</a>';
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
                }])->with(['userProductSegments' => function ($query) {
                    $query->select('id', 'user_id', 'product_segment_id');
                }])
                ->findOrFail($user_id);
                
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
