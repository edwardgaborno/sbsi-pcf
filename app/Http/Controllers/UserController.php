<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Alert;
use Validator;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $getUsers = User::where('id','!=', auth()->user()->id)->orderBy('id')->get();

            return Datatables::of($getUsers)
                ->addIndexColumn()
                ->addColumn('id', function ($data) {
                    return $data->id;
                })
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('email', function ($data) {
                    return $data->email;
                })
                ->addColumn('user_type', function ($data) {
                    return $data->user_type;
                })
                ->addColumn('status', function ($data) {

                    if ($data->status == 1 && $data->is_approve == 1) {
                        $status = '<span class="badge badge-success">Enabled</span> <span class="badge badge-success">Approved</span>';
                    } else if($data->status == 1 && $data->is_approve == 0) {
                        $status = '<span class="badge badge-success">Enabled</span> <span class="badge badge-warning">Pending</span>';
                    } else if($data->status == 0 && $data->is_approve == 1) {
                        $status = '<span class="badge badge-danger">Disabled</span> <span class="badge badge-success">Approved</span>';
                    } else {
                        $status = '<span class="badge badge-danger">Disabled</span> <span class="badge badge-warning">Pending</span>';
                    }

                    return $status;
                })
                ->addColumn('actions', function ($data) {
                    if($data->status == 0 && $data->is_approve == 0) {
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
                    } else if($data->status == 1 && $data->is_approve == 0) {
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
                    } else if($data->status == 0 && $data->is_approve == 1) {
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
                ->escapeColumns([])
                ->make(true);
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!empty($id)) {
            $deleteUser = User::find($id);
            $deleteUser->delete();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }

    public function approveUser($id)
    {
        if (!empty($id)) {
            $approveUser = User::find($id);
            $approveUser->is_approve = 1;
            $approveUser->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }

    public function enableUser($id)
    {
        if (!empty($id)) {
            $enableUser = User::find($id);
            $enableUser->status = 1;
            $enableUser->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }

    public function disableUser($id)
    {
        if (!empty($id)) {
            $disableUser = User::find($id);
            $disableUser->status = 0;
            $disableUser->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }
}
