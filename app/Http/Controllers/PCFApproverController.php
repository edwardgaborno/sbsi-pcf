<?php

namespace App\Http\Controllers;

use App\Models\PCFApprover;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class PCFApproverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $this->authorize('pcf_request_access');

        if ($request->ajax()) {
            $pcfRequest = PCFApprover::where('p_c_f_request_id', $id)->orderBy('created_at', 'desc')->get();          
            return Datatables::of($pcfRequest)
                ->addColumn('approval_status', function ($data) {
                    if ($data->approval_status == 1) {
                        return '<span class="badge badge-success">Approved</span>';
                    }

                    return '<span class="badge badge-danger">Disapproved</span>';
                })
                ->addColumn('done_by', function ($data) {
                    return $data->users->name;
                })
                ->addColumn('position', function ($data) {
                    return $data->users->roles->pluck('name')->first();
                })
                ->addColumn('department', function ($data) {
                    return $data->users->department;
                })
                ->addColumn('remarks', function ($data) {
                    return $data->remarks;
                })
                ->addColumn('date', function ($data) {
                    return $data->created_at->isoFormat('MMMM DD, YYYY h:m A');
                })
                ->rawColumns(['approval_status'])
                ->make(true);
        }
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
     * @param  \App\Models\PCFApprover  $pCFApprover
     * @return \Illuminate\Http\Response
     */
    public function show(PCFApprover $pCFApprover)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PCFApprover  $pCFApprover
     * @return \Illuminate\Http\Response
     */
    public function edit(PCFApprover $pCFApprover)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PCFApprover  $pCFApprover
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PCFApprover $pCFApprover)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PCFApprover  $pCFApprover
     * @return \Illuminate\Http\Response
     */
    public function destroy(PCFApprover $pCFApprover)
    {
        //
    }
}
