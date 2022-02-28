<?php

namespace App\Http\Controllers;

use App\Models\PCFRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PCFList;
use App\Models\UserProductSegment;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->roles->pluck('name')->first() == 'PSR') {

            $ongoingPcfRequest = PCFRequest::where('is_cfo_approved', '!=', 1)->where('created_by', auth()->user()->id)->count();
            $completedPcfRequest = PCFRequest::where('is_cfo_approved', 1)->where('created_by', auth()->user()->id)->count();
            $cancelledPcfRequest = PCFRequest::where('is_cancelled', 1)->where('created_by', auth()->user()->id)->count();

        } else if (auth()->user()->roles->pluck('name')->first() == 'Area Sales Manager' || auth()->user()->roles->pluck('name')->first() == 'Regional Sales Manager') {
            $ongoingPcfRequest = PCFRequest::with('pcfApprover', 'media')
                        ->select('p_c_f_requests.*')
                        ->leftJoin('users', 'users.id', 'p_c_f_requests.created_by')
                        ->where('users.area_region', auth()->user()->area_region)
                        ->where('p_c_f_requests.is_cfo_approved', '!=', 1)
                        ->count(); 

            $completedPcfRequest = PCFRequest::with('pcfApprover', 'media')
                        ->select('p_c_f_requests.*')
                        ->leftJoin('users', 'users.id', 'p_c_f_requests.created_by')
                        ->where('users.area_region', auth()->user()->area_region)
                        ->where('p_c_f_requests.is_cfo_approved', 1)
                        ->count(); 
            
            $cancelledPcfRequest = PCFRequest::with('pcfApprover', 'media')
                        ->select('p_c_f_requests.*')
                        ->leftJoin('users', 'users.id', 'p_c_f_requests.created_by')
                        ->where('users.area_region', auth()->user()->area_region)
                        ->where('p_c_f_requests.is_cancelled', 1)
                        ->count(); 
                        
        }else if (auth()->user()->roles->pluck('name')->first() == 'Area Product Manager') {

            $userSegments = UserProductSegment::where('user_id', auth()->user()->id)->pluck('product_segment_id');
            $ongoingPcfRequest = PCFRequest::with('pcfApprover', 'media')
                            ->select('p_c_f_requests.*')
                            ->leftJoin('users', 'users.id', 'p_c_f_requests.created_by')
                            ->leftJoin('p_c_f_lists', 'p_c_f_lists.pcf_no', 'p_c_f_requests.pcf_no')
                            ->whereIn('p_c_f_lists.product_segment_id', $userSegments)
                            ->where('is_cfo_approved','!=', 1)
                            ->groupBy('p_c_f_requests.pcf_no')
                            ->count();

            $completedPcfRequest = PCFRequest::with('pcfApprover', 'media')
                            ->select('p_c_f_requests.*')
                            ->leftJoin('users', 'users.id', 'p_c_f_requests.created_by')
                            ->leftJoin('p_c_f_lists', 'p_c_f_lists.pcf_no', 'p_c_f_requests.pcf_no')
                            ->whereIn('p_c_f_lists.product_segment_id', $userSegments)
                            ->where('is_cfo_approved', 1)
                            ->groupBy('p_c_f_requests.pcf_no')
                            ->count();

            $cancelledPcfRequest = PCFRequest::with('pcfApprover', 'media')
                            ->select('p_c_f_requests.*')
                            ->leftJoin('users', 'users.id', 'p_c_f_requests.created_by')
                            ->leftJoin('p_c_f_lists', 'p_c_f_lists.pcf_no', 'p_c_f_requests.pcf_no')
                            ->whereIn('p_c_f_lists.product_segment_id', $userSegments)
                            ->where('is_cancelled', 1)
                            ->groupBy('p_c_f_requests.pcf_no')
                            ->count();
        } else {
            $ongoingPcfRequest = PCFRequest::where('is_cfo_approved', '!=', 1)->count();
            $completedPcfRequest = PCFRequest::where('is_cfo_approved', 1)->count();
            $cancelledPcfRequest = PCFRequest::where('is_cancelled', 1)->count();
        }

        // return view('home.index', compact('pendingRequests', 'approvedRequests', 'forApprovals'));

        return view('home.index', [
            'ongoingPcfRequest' => $ongoingPcfRequest,
            'completedPcfRequest' => $completedPcfRequest,
            'cancelledPcfRequest' => $cancelledPcfRequest
        ]);
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
        //
    }
}
