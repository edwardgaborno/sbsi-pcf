<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PCFRequest;
use App\Models\PCFList;
use App\Models\PCFInclusion;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Services\PCFRequestService;
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
        $this->authorize('pcf_request_create');

        //get max value of pcf number
        $pcfMaxVal = PCFRequest::max('pcf_no');
        $rfqMaxVal = PCFRequest::max('rfq_no');

        if(empty($pcfMaxVal) && empty($rfqMaxVal)) {
            $this->pcf_no = '000001';
            $this->rfq_no = '000001';
        } else if(empty($pcfMaxVal) && !empty($rfqMaxVal)) {
            $this->pcf_no = '000001';
            $this->rfq_no = str_pad($rfqMaxVal + 1, 6, "0", STR_PAD_LEFT);
        } else if(!empty($pcfMaxVal) && empty($rfqMaxVal)) {
            $this->rfq_no = '000001';
            $this->pcf_no = str_pad($pcfMaxVal + 1, 6, "0", STR_PAD_LEFT);
        } else {
            $this->pcf_no = str_pad($pcfMaxVal + 1, 6, "0", STR_PAD_LEFT);
            $this->rfq_no = str_pad($rfqMaxVal + 1, 6, "0", STR_PAD_LEFT);
        }

        return view('PCF.sub.create_request', [
            'pcf_no' => $this->pcf_no,
            'rfq_no' => $this->pcf_no,
        ]);
    }

    public function store(StorePCFRequestRequest $request)
    {
        $this->authorize('pcf_request_store');

        DB::beginTransaction();
        try {

            $pcfRequest = PCFRequest::create($request->validated() + [
                'status_id' => 1,
                'institution_id' => $request->institution_id,
                'psr' => auth()->user()->name,
                'created_by' => auth()->user()->id,
            ]);
            $pcfList = PCFList::where('pcf_no', $pcfRequest->pcf_no)->update(['p_c_f_request_id' => $pcfRequest->id]);
            PCFInclusion::where('pcf_no', $pcfRequest->pcf_no)->update(['p_c_f_request_id' => $pcfRequest->id]);

            if ($pcfList == 0) {
                toast()->info('Info', 'You are required to add at least one (1) product in the Item List section.');
                return back();
            }

            DB::commit();
            alert()->success('Success','PCF Request has been created');
        }
        catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect()->route('PCF.index');
    }

    public function edit(PCFRequest $p_c_f_request)
    {
        return view('PCF.edit', compact('p_c_f_request'));
    }

    public function update(UpdatePCFRequestRequest $request, PCFRequest $p_c_f_request)
    {
        $this->authorize('pcf_request_update');

        DB::beginTransaction();

        try {
            $p_c_f_request->update($request->validated() + [
                'institution_id' => $request->institution_id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            alert()->success('Success','PCF Request has been updated');

        }
        catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect()->route('PCF.index');
    }

    public function pcfRequestList(Request $request) 
    {
        $this->authorize('pcf_request_access');
        
        // if ($request->ajax()) {
            
        // }
        $pcfRequest = PCFRequest::with('status', 'media')
                        ->select('p_c_f_requests.*')
                        ->get();

            return Datatables::of($pcfRequest)
                ->addColumn('institution', function ($data) {
                    return $data->institution->institution;
                })
                ->addColumn('date_requested', function ($data) {
                    return $data->created_at->isoFormat('MMMM DD, YYYY');
                })
                ->addColumn('annual_profit', function ($data) {
                    return number_format($data->annual_profit, 2);
                })
                ->addColumn('updated_by', function ($data) {
                    if ($data->updated_by !== null) {
                        return $data->user->name. ' - ' .$data->updated_at->isoFormat('MMM DD, YYYY h:m A');
                    }

                    return '';
                })
                ->addColumn('status', function ($data) {
                    if (auth()->user()->can('psr_view_pcf') && in_array($data->status_id, [1, 2, 3, 4, 5])) {
                        return '<span class="badge badge-light">' . $data->status->find(1)->name . '</span>';
                    } elseif (auth()->user()->can('psr_view_pcf') && $data->status_id == 7) {
                        return '<span class="badge badge-light">' . $data->status->name . '</span>';
                    } else {
                        return '<span class="badge badge-light">' . $data->status->name . '</span>';
                    }
                })
                ->addColumn('actions', function ($data) {

                    $uploadPcf = '<a href="'. route('PCF.edit', [$data->id]) .'" class="badge badge-info">
                                    <i class="fas fa-upload"></i> Upload Approved PCF</a>
                                <a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';

                    $wViewQuotation = '<a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>
                                <a target="_blank" href="' . route('PCF.view_quotation', $data->pcf_no) .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View Quotation (PDF)</a>';

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
                                
                    $wEditApproval = '<a href="'. route('PCF.edit', [$data->id]) .'" class="badge badge-info">
                                    <i class="fas fa-edit"></i> Edit</a>
                                <a href="javascript:void(0);" class="badge badge-success approvePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-up"></i> Approve</a>
                                <a href="javascript:void(0);" class="badge badge-danger disapprovePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-down"></i> Disapprove</a>
                                <a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';
                    
                    $wEditQuotation = '<a href="'. route('PCF.edit', [$data->id]) .'" class="badge badge-info">
                                    <i class="fas fa-edit"></i> Edit</a>
                                <a href="javascript:void(0);" class="badge badge-success approvePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-up"></i> Approve</a>
                                <a href="javascript:void(0);" class="badge badge-danger disapprovePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-down"></i> Disapprove</a>
                                <a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>
                                <a target="_blank" href="' . route('PCF.view_quotation', $data->pcf_no) .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View Quotation (PDF)</a>';

                    $uploadedPcfView = '<a target="_blank" href="' . $data->path() .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';

                    $uploadedPcfwEditView = '<a href="'. route('PCF.edit', [$data->id]) .'" class="badge badge-info">
                                    <i class="fas fa-upload"></i> Upload Approved PCF</a>
                                <a target="_blank" href="' . $data->path() .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';

                    $uploadedPcfApproval = '<a href="javascript:void(0);" class="badge badge-success approvePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-up"></i> Approve</a>
                                <a href="javascript:void(0);" class="badge badge-danger disapprovePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-down"></i> Disapprove</a>
                                <a target="_blank" href="' . $data->path() .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';

                    $uploadedPcfEditApproval = '<a href="'. route('PCF.edit', [$data->id]) .'" class="badge badge-info">
                                    <i class="fas fa-edit"></i> Edit</a>
                                <a href="javascript:void(0);" class="badge badge-success approvePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-up"></i> Approve</a>
                                <a href="javascript:void(0);" class="badge badge-danger disapprovePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-down"></i> Disapprove</a>
                                <a target="_blank" href="' . $data->path() .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';
                    
                    $uploadedPcfWQuotationApproval = '<a href="'. route('PCF.edit', [$data->id]) .'" class="badge badge-info">
                                    <i class="fas fa-edit"></i> Edit</a>
                            <a href="javascript:void(0);" class="badge badge-success approvePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                <i class="far fa-thumbs-up"></i> Approve</a>
                            <a href="javascript:void(0);" class="badge badge-danger disapprovePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                <i class="far fa-thumbs-down"></i> Disapprove</a>
                            <a target="_blank" href="' . $data->path() .'" class="badge badge-light" 
                                rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>
                            <a target="_blank" href="' . route('PCF.view_quotation', $data->pcf_no) .'" class="badge badge-light" 
                                rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View Quotation (PDF)</a>';

                    $uploadedPcfWOEditApproval = '<a href="javascript:void(0);" class="badge badge-success approvePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                            <i class="far fa-thumbs-up"></i> Approve</a>
                        <a href="javascript:void(0);" class="badge badge-danger disapprovePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                            <i class="far fa-thumbs-down"></i> Disapprove</a>
                        <a target="_blank" href="' . $data->path() .'" class="badge badge-light" 
                            rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>
                        <a target="_blank" href="' . route('PCF.view_quotation', $data->pcf_no) .'" class="badge badge-light" 
                            rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View Quotation (PDF)</a>';

                    $uploadedPcfwQuotationView = '<a target="_blank" href="' . $data->path() .'" class="badge badge-light" 
                                rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>
                            <a target="_blank" href="' . route('PCF.view_quotation', $data->pcf_no) .'" class="badge badge-light" 
                                rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View Quotation (PDF)</a>';


                    if (auth()->user()->can('pcf_request_edit')) {
                        if (!empty($data->pcf_document)) {
                            if ((auth()->user()->can('psr_mgr_approve_pcf') || auth()->user()->can('mktg_approve_pcf')) && 
                                ($data->status_id == 1)) {
                                return $uploadedPcfEditApproval;
                            } else if (auth()->user()->can('nsm_approve_pcf') && (in_array($data->status_id, [2, 3]))) {
                                return $uploadedPcfWQuotationApproval;
                            } else if (auth()->user()->can('view_approved_pcf') && in_array($data->status_id, [4, 5, 6])) {
                                return $uploadedPcfwQuotationView;
                            }
                        } else {
                            if ((auth()->user()->can('psr_mgr_approve_pcf') || auth()->user()->can('mktg_approve_pcf')) && 
                                ($data->status_id == 1)) {
                                    return $wEditApproval;
                            } else if (auth()->user()->can('nsm_approve_pcf') && (in_array($data->status_id, [2, 3]))) {
                                return $wEditQuotation;
                            } else if (auth()->user()->can('view_approved_pcf') && in_array($data->status_id, [4, 5, 6])) {
                                return $wViewQuotation;
                            }
                        }
                    }
                    else {
                        if (!empty($data->pcf_document)) {
                            if (auth()->user()->can('psr_view_pcf') && ($data->status_id == 7)) {
                                return $uploadedPcfwEditView;
                            } elseif (auth()->user()->can('psr_view_pcf')) {
                                return $uploadedPcfView;
                            } else if (auth()->user()->can('acct_approve_pcf') && ($data->status_id == 4)) {
                                return $uploadedPcfApproval;
                            } else if (auth()->user()->can('cfo_approve_pcf') && ($data->status_id == 5)) {
                                return $uploadedPcfWOEditApproval;
                            } else if (auth()->user()->can('view_approved_pcf') && in_array($data->status_id, [4, 5, 6])) {
                                return $uploadedPcfwQuotationView;
                            }
                        } else {
                            if (auth()->user()->can('psr_view_pcf') && ($data->status_id == 7)) {
                                return $uploadPcf;
                            } elseif (auth()->user()->can('psr_view_pcf')) {
                                return '<a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-light" 
                                        rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';
                            } else if (auth()->user()->can('acct_approve_pcf') && ($data->status_id == 4)) {
                                return $approval;
                            } else if (auth()->user()->can('cfo_approve_pcf') && ($data->status_id == 5)) {
                                return $wQuotation;
                            } else if (auth()->user()->can('view_approved_pcf') && in_array($data->status_id, [4, 5, 6])) {
                                return $wViewQuotation;
                            }
                        }
                    }            

                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
    }

    public function pcfRequestDetails($pcfRequestId)
    {
        $this->authorize('pcf_request_access');

        $pcf_request = PCFRequest::findOrFail($pcfRequestId);
        
        return response()->json($pcf_request);
    }


    public function approveRequest($pcfRequest_id, PCFRequestService $service)
    {
        $service->approveRequestService($pcfRequest_id);
        return response()->json(['success' => 'success'], 200);
    }

    public function disapproveRequest($pcfRequest_id, PCFRequestService $service)
    {
        $service->disapproveRequestService($pcfRequest_id);
        return response()->json(['success' => 'success'], 200);
    }

    public function storePCFPdfFile(Request $request, PCFRequest $p_c_f_request)
    {
        $this->authorize('psr_upload_pcf');

        $validatedData = $request->validate([
            'pcf_rfq' => ['required',],
        ]);

        DB::beginTransaction();

        try {
            $temporaryFile = TemporaryFile::where('folder', $validatedData)->first();
            if ($temporaryFile) {

                $p_c_f_request->update([
                    'pcf_document' => $temporaryFile->file_name,
                    'status_id' => 1,
                ]);

                $p_c_f_request->addMedia(storage_path('app/pcf_rfq/tmp/' . $request->pcf_rfq . '/' . $temporaryFile->file_name))
                        ->toMediaCollection('approved_pcf_rfq');

                rmdir(storage_path('app/pcf_rfq/tmp/' . $request->pcf_rfq));
                $temporaryFile->delete();
            }

            DB::commit();
            alert()->success('Success', 'The PCF file has been uploaded.');
        }
        catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect()->route('PCF.index');
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

                'p_c_f_institutions.institution as institution',
                'p_c_f_institutions.address as address',
                'p_c_f_institutions.contact_person as contact_person',
                'p_c_f_institutions.designation as designation',
                'p_c_f_institutions.thru_designation as thru_designation',

                // 'p_c_f_requests.date AS date',
                // 'p_c_f_requests.institution AS institution',
                // 'p_c_f_requests.contract_duration AS duration',
                // 'p_c_f_requests.address AS address',
                // 'p_c_f_requests.contact_person AS contact_person',
                // 'p_c_f_requests.designation AS designation',
                // 'p_c_f_requests.thru_designation AS thru_designation',
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
            ->leftJoin('p_c_f_institutions', 'p_c_f_institutions.id', 'p_c_f_requests.institution_id')
            ->join('sources', 'sources.id', 'p_c_f_lists.source_id')
            ->where('p_c_f_lists.pcf_no', $pcf_no)
            ->orderBy('p_c_f_lists.id', 'ASC')
            ->get();

            $get_pcf_inclusions = PCFInclusion::select(
                'p_c_f_inclusions.type as type',
                'p_c_f_inclusions.serial_no as serial_no',
                'p_c_f_inclusions.quantity as quantity',
                'sources.item_code as item_code',
                'sources.description as description',
            )
            ->join('sources', 'sources.id', 'p_c_f_inclusions.source_id')
            ->where('pcf_no', $pcf_no)
            ->get();

            $approver = User::select(
                'users.name as name',
            )
            ->join('p_c_f_requests', 'p_c_f_requests.approved_by', 'users.id')
            ->where('p_c_f_requests.pcf_no', $pcf_no)
            ->get();

            $itemBundles = PCFList::select(
                'bundle_products.quantity AS quantity',

                'sources.item_code AS item_code',
                'sources.description AS description'
            )
            ->join('bundle_products', 'bundle_products.p_c_f_list_id', 'p_c_f_lists.id')
            ->join('sources', 'sources.id', 'bundle_products.source_id')
            ->where('pcf_no', $pcf_no)
            ->get();

            $machineBundles = PCFInclusion::select(
                'bundle_products.quantity AS quantity',

                'sources.item_code AS item_code',
                'sources.description AS description'
            )
            ->join('bundle_products', 'bundle_products.p_c_f_inclusion_id', 'p_c_f_inclusions.id')
            ->join('sources', 'sources.id', 'bundle_products.source_id')
            ->where('pcf_no', $pcf_no)
            ->get();
            
            $pdf = PDF::loadView('PCF.pdf.index', compact('get_pcf_list', 'get_pcf_inclusions', 'pcf_no', 'approver', 'itemBundles', 'machineBundles'));
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
                'p_c_f_requests.status_id AS status',

                'sources.item_code as item_code',
                'sources.description as description',
            )
            ->leftJoin('p_c_f_requests','p_c_f_requests.pcf_no','p_c_f_lists.pcf_no')
            ->join('sources', 'sources.id', 'p_c_f_lists.source_id')
            ->where('p_c_f_lists.pcf_no', $pcf_no)
            ->orderBy('p_c_f_lists.id', 'ASC')
            ->get();

            $pcfInclusions = PCFInclusion::select(
                'p_c_f_inclusions.type as type',
                'p_c_f_inclusions.serial_no as serial_no',
                'p_c_f_inclusions.quantity as quantity',
                'sources.item_code as item_code',
                'sources.description as description',
            )
            ->join('sources', 'sources.id', 'p_c_f_inclusions.source_id')
            ->where('pcf_no', $pcf_no)
            ->get();

            $itemBundles = PCFList::select(
                'bundle_products.quantity AS quantity',

                'sources.item_code AS item_code',
                'sources.description AS description'
            )
            ->join('bundle_products', 'bundle_products.p_c_f_list_id', 'p_c_f_lists.id')
            ->join('sources', 'sources.id', 'bundle_products.source_id')
            ->get();

            $machineBundles = PCFInclusion::select(
                'bundle_products.quantity AS quantity',

                'sources.item_code AS item_code',
                'sources.description AS description'
            )
            ->join('bundle_products', 'bundle_products.p_c_f_inclusion_id', 'p_c_f_inclusions.id')
            ->join('sources', 'sources.id', 'bundle_products.source_id')
            ->get();

            $pdf = PDF::loadView('PCF.quotation.index', compact('pcfList', 'pcfInclusions', 'pcf_no', 'itemBundles', 'machineBundles'));
            $pdf->setPaper('legal', 'portrait');
            return $pdf->stream('quotation.pdf', array("Attachment" => false));
        }

        //return bad request error
        return response()->json(['error' => 'invalid request'], 400);
    }
}
