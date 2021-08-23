<?php

namespace App\Http\Controllers;

use App\Models\PCFRequest;
use App\Models\PCFList;
use Illuminate\Http\Request;
use Alert;
use Validator;
use Yajra\Datatables\Datatables;

class PCFRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $getPCFRequest = PCFRequest::orderBy('pcf_no')->get();

            return Datatables::of($getPCFRequest)
                ->addIndexColumn()
                ->addColumn('pcf_no', function ($data) {
                    return $data->pcf_no;
                })
                ->addColumn('date', function ($data) {
                    return $data->date;
                })
                ->addColumn('institution', function ($data) {
                    return $data->institution;
                })
                ->addColumn('psr', function ($data) {
                    return $data->psr;
                })
                ->addColumn('profit', function ($data) {
                    return $data->profit;
                })
                ->addColumn('profit_rate', function ($data) {
                    return $data->profit_rate;
                })
                ->addColumn('actions', function ($data) {

                    if ($data->status == 0) {

                        return
                        ' 
                        <td style="text-align: center; vertical-align: middle">
                            <a href="#" class="badge badge-info" data-toggle="modal"
                                data-id="'.$data->id .'"
                                data-pcf_no="'.$data->pcf_no .'"
                                data-date="'.$data->date .'"
                                data-institution="'.$data->institution .'"
                                data-duration="'.$data->duration .'"
                                data-date_biding="'.$data->date_biding .'"
                                data-bid_docs_price="'.$data->bid_docs_price .'"
                                data-psr="'.$data->psr .'"
                                data-manager="'.$data->manager .'"
                                data-annual_profit="'.$data->profit .'"
                                data-annual_profit_rate="'.$data->profit_rate .'"
                                data-target="#editPCFRequestModal"
                                onclick="editPCFRequest($(this))">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                            <a href="#" class="badge badge-success"
                                data-id="' . $data->id . '"
                                onclick="ApproveRequest($(this))">
                                <i class="fas fa-check"></i> 
                                Approve
                            </a>
                        </td>
                        ';
                    }

                        return
                            ' 
                        <td style="text-align: center; vertical-align: middle">
                            <a href="#" class="badge badge-info" data-toggle="modal"
                                data-id="'.$data->id .'"
                                data-pcf_no="'.$data->pcf_no .'"
                                data-date="'.$data->date .'"
                                data-institution="'.$data->institution .'"
                                data-duration="'.$data->duration .'"
                                data-date_biding="'.$data->date_biding .'"
                                data-bid_docs_price="'.$data->bid_docs_price .'"
                                data-psr="'.$data->psr .'"
                                data-manager="'.$data->manager .'"
                                data-annual_profit="'.$data->profit .'"
                                data-annual_profit_rate="'.$data->profit_rate .'"
                                data-target="#editPCFRequestModal"
                                onclick="editPCFRequest($(this))">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                            <a href="#" class="badge badge-danger"
                                data-id="' . $data->id . '"
                                onclick="DisApproveRequest($(this))">
                                <i class="fas fa-times"></i> 
                                Dis-Approve
                            </a>
                        </td>
                        ';
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('PCF.index');
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
        $validator = Validator::make($request->all(), [ 
            'pcf_no'   => 'required|string',
            'date'   => 'required|string',
            'institution'   => 'nullable|string',
            'duration_contract'   => 'required|string',
            'date_bidding'   => 'required|string',
            'bid_docs_price'   => 'required|string',
            // 'psr'   => 'required|string',
            'manager'   => 'required|string',
            'annual_profit'   => 'required|string',
            'annual_profit_rate'   => 'nullable|string'
        ]);

        if ($validator->fails()) {
            Alert::error('Invalid Data', $validator->errors()->first()); 
            return view('PCF.index');
        }

        $savePcfRequest = new PCFRequest;
        $savePcfRequest->pcf_no = $request->pcf_no;
        $savePcfRequest->date = $request->date;
        $savePcfRequest->institution = $request->institution;
        $savePcfRequest->duration = $request->duration_contract;
        $savePcfRequest->date_biding = $request->date_bidding;
        $savePcfRequest->bid_docs_price = $request->bid_docs_price;
        $savePcfRequest->psr = \Auth::user()->name;
        $savePcfRequest->manager = $request->manager;
        $savePcfRequest->profit = $request->annual_profit;
        $savePcfRequest->profit_rate = $request->annual_profit_rate;
        $savePcfRequest->created_by = \Auth::user()->id;
        $savePcfRequest->save();

        Alert::success('PCF Request Details', 'Added successfully'); 

        return view('PCF.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PCFRequest  $pCFRequest
     * @return \Illuminate\Http\Response
     */
    public function show(PCFRequest $pCFRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PCFRequest  $pCFRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(PCFRequest $pCFRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PCFRequest  $pCFRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PCFRequest $PCFRequest)
    {
        $validator = Validator::make($request->all(), [ 
            'pcf_request_id' => 'required|numeric',
            'pcf_no'   => 'required|string',
            'date'   => 'required|string',
            'institution'   => 'nullable|string',
            'duration'  => 'required|string',
            'date_biding'   => 'required|string',
            'bid_docs_price'   => 'required|string',
            'psr'   => 'required|string',
            'manager'   => 'required|string',
            'profit'   => 'required|string',
            'profit_rate'   => 'nullable|string'
        ]);

        if ($validator->fails()) {
            Alert::error('Invalid Data', $validator->errors()->first()); 
            return redirect()->route('PCF');
        }

        $savePcfRequest = PCFRequest::findOrFail($request->pcf_request_id);
        $savePcfRequest->date = $request->date;
        $savePcfRequest->institution = $request->institution;
        $savePcfRequest->duration = $request->duration;
        $savePcfRequest->date_biding = $request->date_biding;
        $savePcfRequest->bid_docs_price = $request->bid_docs_price;
        $savePcfRequest->psr = $request->psr;
        $savePcfRequest->manager = $request->manager;
        $savePcfRequest->profit = $request->profit;
        $savePcfRequest->profit_rate = $request->profit_rate;
        $savePcfRequest->save();

        Alert::success('PCF Request Details', 'Updated successfully'); 

        return redirect()->route('PCF');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PCFRequest  $pCFRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(PCFRequest $pCFRequest)
    {
        //
    }

    public function ApproveRequest($id)
    {

        if (!empty($id)) {
            $getRequestSataus = PCFRequest::find($id);
            $getRequestSataus->status = 1;
            $getRequestSataus->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }

    public function DisapproveRequest($id)
    {

        if (!empty($id)) {
            $getRequestSataus = PCFRequest::find($id);
            $getRequestSataus->status = 0;
            $getRequestSataus->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }
}
