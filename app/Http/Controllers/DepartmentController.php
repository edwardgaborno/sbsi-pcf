<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $departments = Department::all();
            return DataTables::of($departments)
                ->addColumn('actions', function ($data) {
                    return '<a href="javascript:void(0)" class="btn btn-primary" onclick="editDepartment(' . $data->id . ')">Edit</a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $columns = [
            ['data' => 'id'],
            ['data' => 'department'],
            ['data' => 'actions'],
        ];

        return view('department.index', [
            'columns' => $columns
        ]);
    }

    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
           'department' => 'required'
       ]);

       if ($validator->fails()) return new JsonResponse(['message' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY); 

        $department = $request->id
            ? Department::find($request->id)
            : new Department();

        $department->department = $request->department;
        $department->save();

        return new JsonResponse(['message' => 'Added department successfully.', 'data' => $department], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $department = Department::findOrFail($id, fn () => new JsonResponse(['message' => 'Department not found.'], Response::HTTP_UNPROCESSABLE_ENTITY));
        return new JsonResponse(['department' => $department->department, 'id' => $department->id], Response::HTTP_OK);
    }
}
