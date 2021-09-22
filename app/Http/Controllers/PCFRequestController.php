<?php

namespace App\Http\Controllers;

use App\Models\PCFRequest;
use App\Models\PCFList;
use App\Models\PCFInclusion;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\Datatables\Datatables;
use PDF;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\PCFRequest\StorePCFRequestRequest;
use App\Http\Requests\PCFRequest\UpdatePCFRequestRequest;

class PCFRequestController extends Controller
{
    private $pcf_no;

    public function index(Request $request)
    {
        $this->authorize('pcf_request_access');
    
        return view('PCF.index');
    }

    public function create(PCFList $pCFList)
    {
        //get max value of pcf number
        $pcfMaxVal = PCFRequest::max('pcf_no');

        if(empty($pcfMaxVal)) {
            $this->pcf_no = '000001';
        } else {
            $this->pcf_no = str_pad($pcfMaxVal + 1, 6, "0", STR_PAD_LEFT);
        }

        return view('PCF.sub.create_request', [
            'pcf_no' => $this->pcf_no,
        ]);
    }

    public function store(StorePCFRequestRequest $request)
    {
        $this->authorize('pcf_request_store');

        $joins = DB::table('sources')
                ->join('p_c_f_lists', 'sources.id', '=', 'p_c_f_lists.source_id')
                ->select('sources.standard_price as standard_price', 'p_c_f_lists.sales as unit_price')
                ->get();
        
        $pcfRequest = PCFRequest::create($request->validated() + [
            'status_id' => 1,
            'psr' => auth()->user()->name,
            'created_by' => auth()->user()->id,
        ]);

        foreach($pcfRequest as $request) {

            PCFList::where('pcf_no', $pcfRequest->pcf_no)->update([
                'p_c_f_request_id' => $pcfRequest->id,
            ]);
            foreach($joins as $join) {
                $join->standard_price <= $join->unit_price ? $asp = 'YES' : $asp = 'NO';

                PCFList::where('pcf_no', $pcfRequest->pcf_no)->update([
                    'above_standard_price' => $asp,
                ]);
            }
        }

        PCFInclusion::where('pcf_no', $pcfRequest->pcf_no)->update([
            'p_c_f_request_id' => $pcfRequest->id,
        ]);

        alert()->success('Success','PCF Request has been created.');

        return redirect()->route('PCF.index');
    }

    public function update(UpdatePCFRequestRequest $request, PCFRequest $PCFRequest)
    {
        $this->authorize('pcf_request_update');

        $updatePCFRequest = PCFRequest::findOrFail($request->pcf_request_id);
        $updatePCFRequest->update($request->validated() + [
            'psr' => auth()->user()->name,
        ]);

        Alert::success('PCF Request Details', 'Updated successfully'); 

        return redirect()->route('PCF.index');
    }

    public function pcfRequestList(Request $request) 
    {
        $this->authorize('pcf_request_access');
        
        if ($request->ajax()) {
            $pcfRequest = PCFRequest::with('status')
                        ->select('p_c_f_requests.*')
                        ->get();

            return Datatables::of($pcfRequest)
                ->addColumn('status', function ($data) {
                    if (auth()->user()->can('pcf_request_edit') && $data->status_id == 1) {
                        return $data->status->find(1)->name;
                    }
                    elseif (auth()->user()->can('pcf_request_edit') && $data->status_id == 8) {
                        return $data->status->name;
                    }
                    else {
                        return $data->status->name;
                    }
                })
                ->addColumn('actions', function ($data) {

                    $dl_action = '<a target="_blank" href="' . route('PCF.download_pdf', $data->pcf_no) .'" class="badge badge-success" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> Download PCF (PDF)</a>
                                <a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-success" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';

                    $wEdit_action = '<a href="#" class="badge badge-info editPCFRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="fas fa-edit"></i> Edit</a>
                                <a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-success" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';
                                
                    $approval_action = '<a href="javascript:void(0);" class="badge badge-success approvePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-up"></i> Approve</a>
                                <a href="javascript:void(0);" class="badge badge-danger disapprovePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-down"></i> Disapprove</a>
                                <a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-success" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';

                    $wQuotation_action = '<a href="javascript:void(0);" class="badge badge-success approvePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-up"></i> Approve</a>
                                <a href="javascript:void(0);" class="badge badge-danger disapprovePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-down"></i> Disapprove</a>
                                <a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-success" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>
                                <a target="_blank" href="' . route('PCF.view_quotation', $data->pcf_no) .'" class="badge badge-success" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View Quotation (PDF)</a>';

                    if (auth()->user()->can('pcf_request_edit')) {
                        if ($data->status_id == 8){
                            return $wEdit_action;
                        }
                        else {
                            return $dl_action;
                        }
                    }
                    else {
                        if(auth()->user()->can('view_quotation') && 
                            ($data->status_id >= 4 && $data->status_id <= 7)) {
                            return $wQuotation_action;
                        }
                        else {
                            return $approval_action;
                        }
                    }
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }
    }

    public function pcfRequestDetails($pcf_request_id)
    {
        $this->authorize('pcf_request_access');

        $pcf_request = PCFRequest::findOrFail($pcf_request_id);
        
        return response()->json($pcf_request);
    }


    public function approveRequest($pcf_request_id)
    {
        $user = auth()->user();
        $pcf_request = PCFRequest::findOrFail($pcf_request_id);

        if ($user->can('psr_mgr_approve_cf') &&  $pcf_request->status_id == 1) {
            $status = 2;
        } else if ($user->can('mktg_approve_pcf') &&  $pcf_request->status_id == 2) {
            $status = 3;
        } else if ($user->can('acct_approve_pcf') &&  $pcf_request->status_id == 3) {
            $status = 4;
        } else if ($user->can('nsm_approve_pcf') &&  $pcf_request->status_id == 4) {
            $status = 5;
        } else if ($user->can('cfo_approve_pcf') &&  $pcf_request->status_id == 5) {
            $status = 6;
        } else if ($user->can('sales_asst_approve_pcf') &&  $pcf_request->status_id == 6) {
            $status = 7;
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        $pcf_request->update([
            'status_id' => $status,
        ]);
            
        return response()->json(['success' => 'success'], 200);
    }

    public function disapproveRequest($pcf_request_id)
    {
        $user = auth()->user();
        $pcf_request = PCFRequest::findOrFail($pcf_request_id);

        if ($user->can('psr_mgr_reject_cf') &&  $pcf_request->status_id == 1) {
            $status = 8;
        } else if ($user->can('mktg_reject_pcf') &&  $pcf_request->status_id == 2) {
            $status = 8;
        } else if ($user->can('acct_reject_pcf') &&  $pcf_request->status_id == 3) {
            $status = 8;
        } else if ($user->can('nsm_reject_pcf') &&  $pcf_request->status_id == 4) {
            $status = 8;
        } else if ($user->can('cfo_reject_pcf') &&  $pcf_request->status_id == 5) {
            $status = 8;
        } else if ($user->can('sales_asst_reject_pcf') &&  $pcf_request->status_id == 6) {
            $status = 8;
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        $pcf_request->update([
            'status_id' => $status,
        ]);
            
        return response()->json(['success' => 'success'], 200);
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

            $pcf_request->addMedia(storage_path('app/pcf_files/tmp/' . $request->upload_file . '/' . $temporaryFile->file_name))
                    ->toMediaCollection('pcf_request_file');

            rmdir(storage_path('app/pcf_files/tmp/' . $request->upload_file));
            $temporaryFile->delete();
        }

        Alert::success('Success', 'The PCF file has been uploaded.');

        return back();
    }

    public function getGrandTotal($pcf_no)
    {
        $grandTotalGrossProfit = PCFList::where('pcf_no', $pcf_no)->sum('gross_profit');
        $grandTotalCostPerYear = PCFInclusion::where('pcf_no', $pcf_no)->sum('cost_year');
        $grandTotalNetSales = PCFList::where('pcf_no', $pcf_no)->sum('total_net_sales'); //ito ung zero

        $annual_profit = $grandTotalGrossProfit - $grandTotalCostPerYear;
        
        if ($grandTotalNetSales > 0) { // pano to if negative? //try natin mag negative
            $annual_profit_rate = ($annual_profit / $grandTotalNetSales) * 100;
        } else { //pag 0 then = to 0 yung din sya
            $annual_profit_rate = 0;
        }

        return response()->json(array(
            'annual_profit' => number_format((float)$annual_profit, 2, '.', ''),
            'annual_profit_rate' => number_format((float)$annual_profit_rate, 0, '.', ''),
        ), 200);
    }

    public function downloadPdf($pcf_no)
    {
        $this->authorize('download_pcf');
        //check if valid request and authorized user

        if (\Auth::check() && !empty($pcf_no)) {

            $get_pcf_list = PCFList::select(
                // 'p_c_f_lists.item_code AS item_code',
                // 'p_c_f_lists.description AS description',
                'p_c_f_lists.quantity AS quantity',
                'p_c_f_lists.sales AS sales',
                'p_c_f_lists.total_sales AS total_sales',
                'p_c_f_requests.date AS date',
                'p_c_f_requests.institution AS institution',
                'p_c_f_requests.contract_duration AS duration',

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
                // 'p_c_f_inclusions.item_code AS inclusions_item_code',
                // 'p_c_f_inclusions.description AS inclusions_description',
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
            $pdf->setPaper('legal', 'portrait');
            return $pdf->download('pcf_request.pdf');
        }

        //return bad request error
        return response()->json(['error' => 'invalid request'], 400);
    }

    public function viewPdf($pcf_no)
    {
        $this->authorize('view_pcf');

        //check if valid request and authorized user
        if (\Auth::check() && !empty($pcf_no)) {

            $get_pcf_list = PCFList::select(
                'p_c_f_lists.quantity AS quantity',
                'p_c_f_lists.sales AS sales',
                'p_c_f_lists.total_sales AS total_sales',
                'p_c_f_lists.above_standard_price AS above_standard_price',
                'sources.item_code as item_code',
                'sources.description as description',
                'p_c_f_requests.date AS date',
                'p_c_f_requests.institution AS institution',
                'p_c_f_requests.contract_duration AS duration',

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
            )
            ->leftJoin('p_c_f_requests','p_c_f_requests.pcf_no','p_c_f_lists.pcf_no')
            ->leftJoin('p_c_f_inclusions','p_c_f_inclusions.pcf_no','p_c_f_lists.pcf_no')
            ->join('sources', 'sources.id', 'p_c_f_lists.source_id')
            ->where('p_c_f_lists.pcf_no', $pcf_no)
            ->orderBy('p_c_f_lists.id', 'DESC')
            ->get();

            $get_pcf_inclusions = PCFInclusion::select(
                'p_c_f_inclusions.type as type',
                'p_c_f_inclusions.serial_no as serial_no',
                'p_c_f_inclusions.quantity as quantity',
                'sources.item_code as item_code',
                'sources.description as description',
            )
            ->join('sources', 'sources.id', 'p_c_f_inclusions.source_id')
            ->where('pcf_no',$pcf_no)
            ->get();
            
            $pdf = PDF::loadView('PCF.pdf.index', compact('get_pcf_list', 'get_pcf_inclusions', 'pcf_no'));
            $pdf->setPaper('legal', 'portrait');
            return $pdf->stream('pcf_request.pdf', array("Attachment" => false));
        }

        //return bad request error
        return response()->json(['error' => 'invalid request'], 400);
    }

    public function viewQuotation($pcf_no)
    {
        $this->authorize('view_quotation');

        //check if valid request and authorized user
        if (\Auth::check() && !empty($pcf_no)) {

            $pcfList = PCFList::select(
                // 'p_c_f_lists.item_code AS item_code',
                // 'p_c_f_lists.description AS description',
                'p_c_f_lists.quantity AS quantity',
                'p_c_f_lists.sales AS sales',
                'p_c_f_lists.total_sales AS total_sales',
                'p_c_f_requests.date AS date',
                'p_c_f_requests.institution AS institution',
                'p_c_f_requests.address AS address',
                'p_c_f_requests.supplier AS supplier',
                'p_c_f_requests.terms AS terms',
                'p_c_f_requests.validity AS validity',
                'p_c_f_requests.delivery AS delivery',
                'p_c_f_requests.warranty AS warranty',
                'sources.item_code as item_code',
                'sources.description as description',
            )
            ->leftJoin('p_c_f_requests','p_c_f_requests.pcf_no','p_c_f_lists.pcf_no')
            ->join('sources', 'sources.id', 'p_c_f_lists.source_id')
            ->where('p_c_f_lists.pcf_no', $pcf_no)
            ->orderBy('p_c_f_lists.id', 'DESC')
            ->get();

            $pdf = PDF::loadView('PCF.quotation.index', compact('pcfList', 'pcf_no'));
            $pdf->setPaper('legal', 'portrait');
            return $pdf->stream('quotation.pdf', array("Attachment" => false));
        }

        //return bad request error
        return response()->json(['error' => 'invalid request'], 400);
    }
}
