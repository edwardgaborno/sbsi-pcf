<?php

namespace App\Http\Controllers;

use App\Models\PCFRequest;
use App\Models\PCFList;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Alert;
use App\Models\PCFInclusion;
use Validator;
use Yajra\Datatables\Datatables;
use PDF;

class PCFRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('psr_access');
        
        if ($request->ajax()) {

            $getPCFRequest = PCFRequest::orderBy('pcf_no')->get();

            return Datatables::of($getPCFRequest)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->status == 0) {
                        $status = '<span class="badge badge-secondary">For Accounting Approval</span>';
                    }
                    elseif ($data->status == 1) {
                        $status = '<span class="badge badge-secondary">Disapproved by the Accounting</span>';
                    }
                    elseif ($data->status == 2) {
                        $status = '<span class="badge badge-secondary">Approved by the Accounting</span>';
                    }
                    elseif ($data->status == 3) {
                        $status = '<span class="badge badge-secondary">Disapproved by the National Sales Manager</span>';
                    }
                    elseif ($data->status == 4) {
                        $status = '<span class="badge badge-secondary">Approved by National Sales Manager</span>';
                    }
                    elseif ($data->status == 5) {
                        $status = '<span class="badge badge-secondary">Disapproved by the Accounting Manager</span>';
                    }
                    elseif ($data->status == 6) {
                        $status = '<span class="badge badge-success">Approved</span>';
                    }

                    return $status;
                })
                ->addColumn('actions', function ($data) {
                    if((auth()->user()->hasRole('PSR') && $data->status == 0)
                        || (auth()->user()->hasRole('PSR') && $data->status == 1)) {
                        return
                        ' 
                        <td style="text-align: center; vertical-align: middle">
                            <a href="#" class="badge badge-info" data-toggle="modal"
                                data-id="'.$data->id .'"
                                data-pcf_no="'.$data->pcf_no .'"
                                data-date="'.$data->date .'"
                                data-institution="'.$data->institution .'"
                                data-address="'.$data->address .'"
                                data-contact_person="'.$data->contact_person .'"
                                data-designation="'.$data->designation .'"
                                data-thru_designation="'.$data->thru_designation .'"
                                data-supplier="'.$data->supplier .'"
                                data-terms="'.$data->terms .'"
                                data-validity="'.$data->validity .'"
                                data-delivery="'.$data->delivery .'"
                                data-warranty="'.$data->warranty .'"
                                data-duration="'.$data->duration .'"
                                data-date_bidding="'.$data->date_bidding .'"
                                data-bid_docs_price="'.$data->bid_docs_price .'"
                                data-psr="'.$data->psr .'"
                                data-manager="'.$data->manager .'"
                                data-annual_profit="'.$data->annual_profit .'"
                                data-annual_profit_rate="'.$data->annual_profit_rate .'"
                                data-target="#editPCFRequestModal"
                                onclick="editPCFRequest($(this))">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                            <a href="' . route('PCF.download_pdf', $data->pcf_no) .'" class="badge badge-success">
                                <i class="far fa-file-pdf"></i>
                                Download PDF
                            </a>
                        </td>
                        ';
                    }   
                    else if((auth()->user()->hasRole('Accounting') && $data->status == 0)
                            || (auth()->user()->hasRole('Accounting') && $data->status == 1)
                            || auth()->user()->hasRole('Accounting') && $data->status == 3) {
                        return
                        ' 
                            <td style="text-align: center; vertical-align: middle">
                                <a href="#" class="badge badge-info" data-toggle="modal"
                                    data-id="'.$data->id .'"
                                    data-pcf_no="'.$data->pcf_no .'"
                                    data-date="'.$data->date .'"
                                    data-institution="'.$data->institution .'"
                                    data-duration="'.$data->duration .'"
                                    data-date_biding="'.$data->date_bidding .'"
                                    data-bid_docs_price="'.$data->bid_docs_price .'"
                                    data-psr="'.$data->psr .'"
                                    data-manager="'.$data->manager .'"
                                    data-annual_profit="'.$data->profit .'"
                                    data-annual_profit_rate="'.$data->profit_rate .'"
                                    data-target="#editPCFRequestModal"
                                    onclick="editPCFRequest($(this))">
                                    <i class="fas fa-edit"></i>
                                    View
                                </a>
                                <a href="#" class="badge badge-success"
                                    data-id="' . $data->id . '"
                                    onclick="ApproveRequest($(this))">
                                    <i class="fas fa-check"></i> 
                                    Approve
                                </a>
                                <a href="#" class="badge badge-danger"
                                data-id="' . $data->id . '"
                                    onclick="DisApproveRequest($(this))">
                                    <i class="fas fa-times"></i> 
                                    Disapprove
                                </a>
                                <a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-success" rel="noopener noreferrer">
                                    <i class="far fa-file-pdf"></i>
                                    View PCF
                                </a>
                            </td>
                        ';
                    }
                    else if((auth()->user()->hasRole('National Sales Manager') && $data->status == 2)
                            || (auth()->user()->hasRole('National Sales Manager') && $data->status == 5)) {
                        return
                        ' 
                            <td style="text-align: center; vertical-align: middle">
                                <a href="#" class="badge badge-success"
                                    data-id="' . $data->id . '"
                                    onclick="ApproveRequest($(this))">
                                    <i class="fas fa-check"></i> 
                                    Approve
                                </a>
                                <a href="#" class="badge badge-danger"
                                data-id="' . $data->id . '"
                                    onclick="DisApproveRequest($(this))">
                                    <i class="fas fa-times"></i> 
                                    Disapprove
                                </a>
                                <a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-success" rel="noopener noreferrer">
                                    <i class="far fa-file-pdf"></i>
                                    View PCF
                                </a>
                            </td>
                        ';
                    }
                    else if(auth()->user()->hasRole('Accounting Manager') && $data->status == 4) {
                        return
                        ' 
                            <td style="text-align: center; vertical-align: middle">
                                <a href="#" class="badge badge-success"
                                    data-id="' . $data->id . '"
                                    onclick="ApproveRequest($(this))">
                                    <i class="fas fa-check"></i> 
                                    Approve
                                </a>
                                <a href="#" class="badge badge-danger"
                                    data-id="' . $data->id . '"
                                    onclick="DisApproveRequest($(this))">
                                    <i class="fas fa-times"></i> 
                                    Disapprove
                                </a>
                                <a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-success" rel="noopener noreferrer">
                                    <i class="far fa-file-pdf"></i>
                                    View PCF
                                </a>
                            </td>
                        ';
                    }
                })
                ->rawColumns(['status', 'actions'])
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
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'designation' => 'nullable|string',
            'thru_designation' => 'nullable|string',
            'supplier' => 'required|string',
            'terms' => 'required|string',
            'validity' => 'required|string',
            'delivery' => 'required|string',
            'warranty' => 'nullable|string',
            'duration_contract'   => 'required|string',
            'date_bidding'   => 'required|string',
            'bid_docs_price'   => 'required|string',
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
        $savePcfRequest->address = $request->address;
        $savePcfRequest->contact_person = $request->contact_person;
        $savePcfRequest->designation = $request->designation;
        $savePcfRequest->thru_designation = $request->thru_designation;
        $savePcfRequest->supplier = $request->supplier;
        $savePcfRequest->terms = $request->terms;
        $savePcfRequest->validity = $request->validity;
        $savePcfRequest->delivery = $request->delivery;
        $savePcfRequest->warranty = $request->warranty;
        $savePcfRequest->duration = $request->duration_contract;
        $savePcfRequest->date_bidding = $request->date_bidding;
        $savePcfRequest->bid_docs_price = $request->bid_docs_price;
        $savePcfRequest->psr = \Auth::user()->name;
        $savePcfRequest->manager = $request->manager;
        $savePcfRequest->annual_profit = $request->annual_profit;
        $savePcfRequest->annual_profit_rate = $request->annual_profit_rate;
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
            'pcf_no'   => 'required|string',
            'date'   => 'required|string',
            'institution'   => 'nullable|string',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'designation' => 'nullable|string',
            'thru_designation' => 'nullable|string',
            'supplier' => 'required|string',
            'terms' => 'required|string',
            'validity' => 'required|string',
            'delivery' => 'required|string',
            'warranty' => 'nullable|string',
            'duration'   => 'required|string',
            'date_bidding'   => 'required|string',
            'bid_docs_price'   => 'required|string',
            'manager'   => 'required|string',
            'annual_profit'   => 'nullable|string',
            'annual_profit_rate'   => 'nullable|string'
        ]);

        if ($validator->fails()) {
            Alert::error('Invalid Data', $validator->errors()->first()); 
            return redirect()->route('PCF');
        }

        $updatePCFRequest = PCFRequest::findOrFail($request->pcf_request_id);
        $updatePCFRequest->pcf_no = $request->pcf_no;
        $updatePCFRequest->date = $request->date;
        $updatePCFRequest->institution = $request->institution;
        $updatePCFRequest->address = $request->address;
        $updatePCFRequest->contact_person = $request->contact_person;
        $updatePCFRequest->designation = $request->designation;
        $updatePCFRequest->thru_designation = $request->thru_designation;
        $updatePCFRequest->supplier = $request->supplier;
        $updatePCFRequest->terms = $request->terms;
        $updatePCFRequest->validity = $request->validity;
        $updatePCFRequest->delivery = $request->delivery;
        $updatePCFRequest->warranty = $request->warranty;
        $updatePCFRequest->duration = $request->duration;
        $updatePCFRequest->date_bidding = $request->date_bidding;
        $updatePCFRequest->bid_docs_price = $request->bid_docs_price;
        $updatePCFRequest->psr = \Auth::user()->name;
        $updatePCFRequest->manager = $request->manager;
        $updatePCFRequest->annual_profit = $request->annual_profit;
        $updatePCFRequest->annual_profit_rate = $request->annual_profit_rate;
        $updatePCFRequest->status = 0;
        $updatePCFRequest->created_by = \Auth::user()->id;
        $updatePCFRequest->save();

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
            $request = PCFRequest::find($id);
            if ( (auth()->user()->hasRole('Accounting') && $request->status == 0) ||
                (auth()->user()->hasRole('Accounting') && $request->status == 3)) {
                $request->status = 2;
                $request->save();
            }
            if((auth()->user()->hasRole('National Sales Manager') && $request->status == 2) ||
                (auth()->user()->hasRole('National Sales Manager') && $request->status == 5)) {
                $request->status = 4;
                $request->save();
            }
            if(auth()->user()->hasRole('Accounting Manager')&& $request->status == 4){
                $request->status = 6;
                $request->save();
            }

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }

    public function DisapproveRequest($id)
    {
        if (!empty($id)) {
            $request = PCFRequest::find($id);
            if((auth()->user()->hasRole('Accounting') && $request->status == 0) ||
                (auth()->user()->hasRole('Accounting') && $request->status == 3)) {
                $request->status = 1;
                $request->save();
            }
            if((auth()->user()->hasRole('National Sales Manager') && $request->status == 2) ||
                (auth()->user()->hasRole('National Sales Manager') && $request->status == 5)) {
                $request->status = 3;
                $request->save();
            }
            if(auth()->user()->hasRole('Accounting Manager') && $request->status == 4){
                $request->status = 5;
                $request->save();
            }

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }

    public function downloadPdf($pcf_no)
    {
        $this->authorize('psr_download_pcf');
        //check if valid request and authorized user
        if (\Auth::check() && !empty($pcf_no)) {

            $get_pcf_list = PCFList::select(
                'p_c_f_lists.item_code AS item_code',
                'p_c_f_lists.description AS description',
                'p_c_f_lists.quantity AS quantity',
                'p_c_f_lists.sales AS sales',
                'p_c_f_lists.total_sales AS total_sales',
                'p_c_f_lists.above_standard_price AS above_standard_price',
                'p_c_f_requests.date AS date',
                'p_c_f_requests.institution AS institution',
                'p_c_f_requests.duration AS duration',

                'p_c_f_requests.address AS address',
                'p_c_f_requests.contact_person AS contact_person',
                'p_c_f_requests.designation AS designation',
                'p_c_f_requests.thru_designation AS thru_designation',
                'p_c_f_requests.supplier AS supplier',
                'p_c_f_requests.terms AS terms',
                'p_c_f_requests.validity AS validity',
                'p_c_f_requests.delivery AS delivery',
                'p_c_f_requests.warranty AS warranty',

                'p_c_f_requests.date_bidding AS date_biding',
                'p_c_f_requests.bid_docs_price AS bid_docs_price',
                'p_c_f_requests.psr AS psr',
                'p_c_f_requests.manager AS manager',
                'p_c_f_requests.annual_profit AS annual_profit',
                'p_c_f_requests.annual_profit_rate AS annual_profit_rate',
                'p_c_f_inclusions.item_code AS inclusions_item_code',
                'p_c_f_inclusions.description AS inclusions_description',
                'p_c_f_inclusions.type AS inclusions_type',
                'p_c_f_inclusions.quantity AS inclusions_qty',
            )
            ->leftJoin('p_c_f_requests','p_c_f_requests.pcf_no','p_c_f_lists.pcf_no')
            ->leftJoin('p_c_f_inclusions','p_c_f_inclusions.pcf_no','p_c_f_lists.pcf_no')
            ->where('p_c_f_lists.pcf_no', $pcf_no)
            ->orderBy('p_c_f_lists.id', 'DESC')
            ->get();

            $get_pcf_inclusions = PCFInclusion::where('pcf_no',$pcf_no)->get();
            
            $pdf = PDF::loadView('PCF.pdf.index', compact('get_pcf_list', 'get_pcf_inclusions', 'pcf_no'));
            $pdf->setPaper('legal', 'landscape');
            return $pdf->download('pcf_request.pdf');
        }

        //return bad request error
        return resonponse()->json(['error' => 'invalid request'], 400);
    }

    public function viewPdf($pcf_no)
    {
        $this->authorize('psr_view_pcf');

        //check if valid request and authorized user
        if (\Auth::check() && !empty($pcf_no)) {

            $get_pcf_list = PCFList::select(
                'p_c_f_lists.item_code AS item_code',
                'p_c_f_lists.description AS description',
                'p_c_f_lists.quantity AS quantity',
                'p_c_f_lists.sales AS sales',
                'p_c_f_lists.total_sales AS total_sales',
                'p_c_f_requests.date AS date',
                'p_c_f_requests.institution AS institution',
                'p_c_f_requests.duration AS duration',

                'p_c_f_requests.address AS address',
                'p_c_f_requests.contact_person AS contact_person',
                'p_c_f_requests.designation AS designation',
                'p_c_f_requests.thru_designation AS thru_designation',
                'p_c_f_requests.supplier AS supplier',
                'p_c_f_requests.terms AS terms',
                'p_c_f_requests.validity AS validity',
                'p_c_f_requests.delivery AS delivery',
                'p_c_f_requests.warranty AS warranty',

                'p_c_f_requests.date_bidding AS date_biding',
                'p_c_f_requests.bid_docs_price AS bid_docs_price',
                'p_c_f_requests.psr AS psr',
                'p_c_f_requests.manager AS manager',
                'p_c_f_requests.annual_profit AS annual_profit',
                'p_c_f_requests.annual_profit_rate AS annual_profit_rate',
                'p_c_f_inclusions.item_code AS inclusions_item_code',
                'p_c_f_inclusions.description AS inclusions_description',
                'p_c_f_inclusions.type AS inclusions_type',
                'p_c_f_inclusions.quantity AS inclusions_qty',
            )
            ->leftJoin('p_c_f_requests','p_c_f_requests.pcf_no','p_c_f_lists.pcf_no')
            ->leftJoin('p_c_f_inclusions','p_c_f_inclusions.pcf_no','p_c_f_lists.pcf_no')
            ->where('p_c_f_lists.pcf_no', $pcf_no)
            ->orderBy('p_c_f_lists.id', 'DESC')
            ->get();

            $get_pcf_inclusions = PCFInclusion::where('pcf_no',$pcf_no)->get();
            
            $pdf = PDF::loadView('PCF.pdf.index', compact('get_pcf_list', 'get_pcf_inclusions', 'pcf_no'));
            $pdf->setPaper('legal', 'landscape');
            return $pdf->stream('pcf_request.pdf', array("Attachment" => false));
        }

        //return bad request error
        return resonponse()->json(['error' => 'invalid request'], 400);
    }

    public function storePCFPdfFile(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'upload_file' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Invalid Data', $validator->errors()->first()); 
            return redirect()->route('PCF');
        }

        $pcf_request = PCFRequest::findOrFail($request->pcf_id);
    
        $temporaryFile = TemporaryFile::where('folder', $request->upload_file)->first();
        if ($temporaryFile) {

            $pcf_request->update([
                'pcf_document' => $temporaryFile->file_name,
            ]);

            $pcf_request->addMedia(storage_path('pcf_documents/files/tmp/' . $request->upload_file . '/' . $temporaryFile->file_name))
                    ->toMediaCollection('pcf_request_file');

            rmdir(storage_path('pcf_documents/files/tmp/' . $request->upload_file));
            $temporaryFile->delete();
        }

        Alert::success('Success', 'The PCF file has been uploaded.');

        return back();
    }
}
