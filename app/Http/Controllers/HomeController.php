<?php

namespace App\Http\Controllers;

use App\Models\PCFRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PCFList;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $pendingRequests = PCFRequest::with('status')
        //             ->where('status_id', 1)
        //             ->count();

        // $approvedRequests = PCFRequest::with('status')
        //             ->where('status_id', 6)
        //             ->count();

        // $forApprovals = PCFRequest::with('status')
        //             ->whereIn('status_id', [2, 3])
        //             ->count();

        // return view('home.index', compact('pendingRequests', 'approvedRequests', 'forApprovals'));

        return view('home.index');
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
