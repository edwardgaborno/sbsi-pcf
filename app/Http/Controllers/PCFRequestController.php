<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PCFRequest;
use App\Models\PCFList;
use App\Models\PCFInclusion;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\PCFRequest\StorePCFRequestRequest;
use App\Http\Requests\PCFRequest\UpdatePCFRequestRequest;
use App\Notifications\ApprovePCFRequestNotification;
use App\Notifications\AccountingApprovedPCFRequestNotification;
use App\Notifications\AccountingDisapprovedPCFRequestNotification;

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

        DB::beginTransaction();

        try {

            $pcfRequest = PCFRequest::create($request->validated() + [
                'status_id' => 1,
                'psr' => auth()->user()->name,
                'created_by' => auth()->user()->id,
            ]);

            PCFList::where('pcf_no', $pcfRequest->pcf_no)->update([
                'p_c_f_request_id' => $pcfRequest->id,
            ]);

            PCFInclusion::where('pcf_no', $pcfRequest->pcf_no)->update([
                'p_c_f_request_id' => $pcfRequest->id,
            ]);

            DB::commit();
            alert()->success('Success','PCF Request has been created.');
        }
        catch (\Throwable $th) {

            DB::rollBack();
        }

        return redirect()->route('PCF.index');
    }

    public function update(UpdatePCFRequestRequest $request, PCFRequest $PCFRequest)
    {
        $this->authorize('pcf_request_update');

        DB::beginTransaction();

        try {
            $pcfRequest = PCFRequest::findOrFail($request->pcf_request_id);
            $pcfRequest->update($request->validated() + [
                'psr' => auth()->user()->name,
                'status_id' => 1,
            ]);

            DB::commit();
            alert()->success('Success','PCF Request has been updated.');

        }
        catch (\Throwable $th) {
            DB::rollBack();
        }

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
                        return '<span class="badge badge-light">' . $data->status->find(1)->name . '</span>';
                    }
                    elseif (auth()->user()->can('pcf_request_edit') && $data->status_id == 8) {
                        return '<span class="badge badge-light">' . $data->status->name . '</span>';
                    }
                    else {
                        return '<span class="badge badge-light">' . $data->status->name . '</span>';
                    }
                })
                ->addColumn('actions', function ($data) {

                    $vAction = '<a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';

                    $wEdit_action = '<a href="#" class="badge badge-info editPCFRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="fas fa-edit"></i> Edit</a>
                                <a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';
                                
                    $approval = '<a href="javascript:void(0);" class="badge badge-success approvePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-up"></i> Approve</a>
                                <a href="javascript:void(0);" class="badge badge-danger disapprovePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-down"></i> Disapprove</a>
                                <a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';
                    
                    $wQuotation = '<a href="javascript:void(0);" class="badge badge-success approvePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-up"></i> Approve</a>
                                <a href="javascript:void(0);" class="badge badge-danger disapprovePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-down"></i> Disapprove</a>
                                <a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>
                                <a target="_blank" href="' . route('PCF.view_quotation', $data->pcf_no) .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View Quotation (PDF)</a>';

                    $uploadedPcf = '<a href="#" class="badge badge-info editPCFRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="fas fa-edit"></i> Edit</a>
                                <a target="_blank" href="' . $data->path() .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';

                    $wUploadApproval = '<a href="javascript:void(0);" class="badge badge-success approvePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-up"></i> Approve</a>
                                <a href="javascript:void(0);" class="badge badge-danger disapprovePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-down"></i> Disapprove</a>
                                <a target="_blank" href="' . $data->path() .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';
                    
                    $wUploadedQuotation = '<a href="javascript:void(0);" class="badge badge-success approvePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-up"></i> Approve</a>
                                <a href="javascript:void(0);" class="badge badge-danger disapprovePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-down"></i> Disapprove</a>
                                <a target="_blank" href="' . $data->path() .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>
                                <a target="_blank" href="' . route('PCF.view_quotation', $data->pcf_no) .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View Quotation (PDF)</a>';

                    $salesAsstView = '<a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-light" 
                                        rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)
                                    <a target="_blank" href="' . route('PCF.view_quotation', $data->pcf_no) .'" class="badge badge-light" 
                                        rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View Quotation (PDF)</a>';

                    $uploadedPcf_salesAsstView = '<a target="_blank" href="' . $data->path() .'" class="badge badge-light" 
                                        rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>
                                    <a target="_blank" href="' . route('PCF.view_quotation', $data->pcf_no) .'" class="badge badge-light" 
                                        rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View Quotation (PDF)</a>';

                    if (auth()->user()->can('pcf_request_edit')) {
                        if ($data->status_id == 7){
                            if (!empty($data->pcf_document)) { //check if there's an uploaded file, show it instead;
                                return $uploadedPcf;
                            } else {
                                return $wEdit_action;
                            }
                        }
                        else {
                            if (!empty($data->pcf_document)) {
                                return $uploadedPcf;
                            } else {
                                return $vAction;
                            }
                        }
                    }
                    else {
                        if (!empty($data->pcf_document)) {
                            if (auth()->user()->can('psr_mgr_approve_pcf') && ($data->status_id == 1)) {
                                return $wUploadApproval;
                            }
                            elseif (auth()->user()->can('mktg_approve_pcf') && ($data->status_id == 2)) {
                                return $wUploadApproval;
                            }
                            elseif (auth()->user()->can('acct_approve_pcf') && ($data->status_id == 3)) {
                                return $wUploadApproval;
                            }
                            elseif (auth()->user()->can('nsm_approve_pcf') && ($data->status_id == 4)) {
                                return $wUploadedQuotation;
                            }
                            elseif (auth()->user()->can('cfo_approve_pcf') && ($data->status_id == 5)) {
                                return $wUploadedQuotation;
                            }
                            elseif (auth()->user()->can('sales_asst_view') && ($data->status_id == 6)) {
                                return $uploadedPcf_salesAsstView;
                            }
                        }
                        else {
                            if (auth()->user()->can('psr_mgr_approve_pcf') && ($data->status_id == 1)) {
                                return $approval;
                            }
                            elseif (auth()->user()->can('mktg_approve_pcf') && ($data->status_id == 2)) {
                                return $approval;
                            }
                            elseif (auth()->user()->can('acct_approve_pcf') && ($data->status_id == 3)) {
                                return $approval;
                            }
                            elseif (auth()->user()->can('nsm_approve_pcf') && ($data->status_id == 4)) {
                                return $wQuotation;
                            }
                            elseif (auth()->user()->can('cfo_approve_pcf') && ($data->status_id == 5)) {
                                return $wQuotation;
                            }
                            elseif (auth()->user()->can('sales_asst_view') && ($data->status_id == 6)) {
                                    return $salesAsstView;
                            }
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
        DB::beginTransaction();

        $user = auth()->user();
        $pcfRequest = PCFRequest::findOrFail($pcf_request_id);

        $psr = User::find($pcfRequest->created_by);
        $salesAsst = User::role('Sales Assistant')->get();
        $nsms = User::role('National Sales Manager')->get(); 
        $cfos = User::role('Chief Finance Officer')->get(); 

        if ($user->can('psr_mgr_approve_pcf') &&  $pcfRequest->status_id == 1) {
            $status = 2;
        } else if ($user->can('mktg_approve_pcf') &&  $pcfRequest->status_id == 2) {
            $status = 3;
        } else if ($user->can('acct_approve_pcf') &&  $pcfRequest->status_id == 3) {

            $status = 4;

            $pcfRequest->update(['approved_by' => $user->id,]);

            foreach($salesAsst as $asst) {
                $psr->notify(new AccountingApprovedPCFRequestNotification(
                    $asst->email,
                    $user->name,
                    $pcfRequest->institution, 
                    $pcfRequest->supplier,
                    $psr->name
                ));
            }

        } else if ($user->can('nsm_approve_pcf') &&  $pcfRequest->status_id == 4 
            && $pcfRequest->countDistinct($pcfRequest->id) > 1) {

                $status = 5;

        } else if ($user->can('nsm_approve_pcf') &&  $pcfRequest->status_id == 4 
            && $pcfRequest->countDistinct($pcfRequest->id) == 1
            && $pcfRequest->checkColumnValue($pcfRequest->id) == 'NO') {

                $status = 5;

        } else if ($user->can('nsm_approve_pcf') &&  $pcfRequest->status_id == 4 
            && $pcfRequest->countDistinct($pcfRequest->id) == 1
            && $pcfRequest->checkColumnValue($pcfRequest->id) == 'YES') {

                $acct = User::find($pcfRequest->approved_by);
                $status = 6;

                foreach($salesAsst as $asst) {
                    foreach($nsms as $nsm) {
                        foreach($cfos as $cfo) {
                            $psr->notify(new ApprovePCFRequestNotification(
                                $asst->email,
                                $acct->name, 
                                $pcfRequest->institution, 
                                $pcfRequest->supplier,
                                $psr->name,
                                $nsm->name,
                                $cfo->name
                            ));
                        }
                    }
                }

        } else if ($user->can('cfo_approve_pcf') &&  $pcfRequest->status_id == 5) {

                $acct = User::find($pcfRequest->approved_by);
                $status = 6;

                foreach($salesAsst as $asst) {
                    foreach($nsms as $nsm) {
                        foreach($cfos as $cfo) {
                            $psr->notify(new ApprovePCFRequestNotification(
                                $asst->email,
                                $acct->name, 
                                $pcfRequest->institution, 
                                $pcfRequest->supplier,
                                $psr->name,
                                $nsm->name,
                                $cfo->name
                            ));
                        }
                    }
                }

        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        try {
            $pcfRequest->update([
                'status_id' => $status,
            ]);
                
            DB::commit();
            return response()->json(['success' => 'success'], 200);
        }
        catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function disapproveRequest($pcf_request_id)
    {
        DB::beginTransaction();

        $user = auth()->user();
        $pcfRequest = PCFRequest::findOrFail($pcf_request_id);

        $psr = User::find($pcfRequest->created_by);
        $acct = User::find($user->id);
        $salesAsst = User::role('Sales Assistant')->get(); 

        if ($user->can('psr_mgr_reject_pcf') &&  $pcfRequest->status_id == 1) {
            $status = 7;
        } else if ($user->can('mktg_reject_pcf') &&  $pcfRequest->status_id == 2) {
            $status = 7;
        } else if ($user->can('acct_reject_pcf') &&  $pcfRequest->status_id == 3) {
            $status = 7;

            foreach($salesAsst as $asst) {
                $psr->notify(new AccountingDisapprovedPCFRequestNotification(
                    $asst->email,
                    $acct->name, 
                    $pcfRequest->institution, 
                    $pcfRequest->supplier,
                    $psr->name
                ));
            }

        } else if ($user->can('nsm_reject_pcf') &&  $pcfRequest->status_id == 4) {
            $status = 7;
        } else if ($user->can('cfo_reject_pcf') &&  $pcfRequest->status_id == 5) {
            $status = 7;
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        try {
            $pcfRequest->update([
                'status_id' => $status,
            ]);

            DB::commit();
            return response()->json(['success' => 'success'], 200);
        }
        catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function storePCFPdfFile(Request $request)
    {
        $this->authorize('upload_pcf');

        $validatedData = $request->validate([
            'upload_file' => ['required',],
        ]);

        DB::beginTransaction();

        try {
            $pcf_request = PCFRequest::findOrFail($request->pcf_id);

            $temporaryFile = TemporaryFile::where('folder', $validatedData)->first();
            if ($temporaryFile) {

                $pcf_request->update([
                    'pcf_document' => $temporaryFile->file_name,
                    'status_id' => 1,
                ]);

                $pcf_request->addMedia(storage_path('app/pcf_files/tmp/' . $request->upload_file . '/' . $temporaryFile->file_name))
                        ->toMediaCollection('pcf_request_file');

                rmdir(storage_path('app/pcf_files/tmp/' . $request->upload_file));
                $temporaryFile->delete();
            }

            DB::commit();
            alert()->success('Success', 'The PCF file has been uploaded.');
        }
        catch (\Throwable $th) {
            DB::rollBack();
        }

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

    public function viewPdf($pcf_no)
    {
        $this->authorize('view_pcf');

        if (auth()->check() && !empty($pcf_no)) {

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
                'p_c_f_requests.date_bidding AS date_bidding',
                'p_c_f_requests.bid_docs_price AS bid_docs_price',
                'p_c_f_requests.psr AS psr',
                'p_c_f_requests.manager AS manager',
                'p_c_f_requests.annual_profit AS annual_profit',
                'p_c_f_requests.annual_profit_rate AS annual_profit_rate',

            )
            ->leftJoin('p_c_f_requests','p_c_f_requests.pcf_no','p_c_f_lists.pcf_no')
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

            $approver = User::select(
                'users.name as name',
            )
            ->join('p_c_f_requests', 'p_c_f_requests.approved_by', 'users.id')
            ->where('p_c_f_requests.pcf_no', $pcf_no)
            ->get();
            
            $pdf = PDF::loadView('PCF.pdf.index', compact('get_pcf_list', 'get_pcf_inclusions', 'pcf_no', 'approver'));
            $pdf->setPaper('legal', 'portrait');
            return $pdf->stream('PCF NO_'. $get_pcf_list[0]->institution .'_' . $get_pcf_list[0]->supplier . '_' .$get_pcf_list[0]->psr .'.pdf', array("Attachment" => false));
        }

        return response()->json(['error' => 'invalid request'], 400);
    }

    public function viewQuotation($pcf_no)
    {
        $this->authorize('view_quotation');

        if (auth()->check() && !empty($pcf_no)) {

            $pcfList = PCFList::select(
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

            $pcfInclusions = PCFInclusion::select(
                'p_c_f_inclusions.type as type',
                'p_c_f_inclusions.serial_no as serial_no',
                'p_c_f_inclusions.quantity as quantity',
                'sources.item_code as item_code',
                'sources.description as description',
            )
            ->join('sources', 'sources.id', 'p_c_f_inclusions.source_id')
            ->where('pcf_no',$pcf_no)
            ->get();

            $pdf = PDF::loadView('PCF.quotation.index', compact('pcfList', 'pcfInclusions', 'pcf_no'));
            $pdf->setPaper('legal', 'portrait');
            return $pdf->stream('quotation.pdf', array("Attachment" => false));
        }

        //return bad request error
        return response()->json(['error' => 'invalid request'], 400);
    }
}
