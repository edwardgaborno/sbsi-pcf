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
use App\Models\PCFApprover;

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
                'institution_id' => $request->institution_id,
                'created_by' => auth()->user()->id,
                'rfq_no' => 'SAL.01.' . $request->rfq_no,
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
        
        if ($request->ajax()) {
            $pcfRequest = PCFRequest::with('pcfApprover', 'media')
                        ->select('p_c_f_requests.*')
                        // ->where('p_c_f_requests.is_cancelled','!=', 1)
                        ->orderBy('pcf_no', 'DESC')
                        ->get();            
            return Datatables::of($pcfRequest)
                ->addColumn('institution', function ($data) {
                    return $data->institution->institution;
                })
                ->addColumn('psr', function ($data) {
                    return $data->user->name;
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
                    $getTotalApprove = PCFApprover::where('p_c_f_request_id', $data->id)->where('approval_status', 1)->count();
                    $getTotalDisapprove = PCFApprover::where('p_c_f_request_id', $data->id)->where('approval_status', 0)->count();

                    if ($data->is_cancelled) {
                        return '<a href="#" class="badge badge-danger">Cancelled</a>';
                    }
                    
                    if ($data->is_psr_manager_approved && $data->is_marketing_approved && $data->is_nsm_approved && $data->is_cfo_approved && $data->is_accounting_approved) {
                        return '<a href="#" data-toggle="modal" data-target="#view_approval_status_modal" class="badge badge-primary view-approval-details" data-pcf_request_id="'.$data->id.'"> <span class="badge badge-success">Completed</span> View Approval</a>';
                    } else if ($getTotalApprove == 0 && $getTotalDisapprove == 0) {
                        return '<a href="#" data-toggle="modal" data-target="#view_approval_status_modal" class="badge badge-primary view-approval-details" data-pcf_request_id="'.$data->id.'"> <span class="badge badge-warning">Processing </span> View Approval</a>';
                    } else if($getTotalApprove > 0 && $getTotalDisapprove == 0) {
                        return '<a href="#" data-toggle="modal" data-target="#view_approval_status_modal" class="badge badge-primary view-approval-details" data-pcf_request_id="'.$data->id.'"> <span class="badge badge-success">' . $getTotalApprove . ' Approved </span> View Approval</a>';
                    }
                    return '<a href="#" data-toggle="modal" data-target="#view_approval_status_modal" class="badge badge-primary view-approval-details" data-pcf_request_id="'.$data->id.'"> <span class="badge badge-success">' . $getTotalApprove . ' Approved </span> View Approval</a>';
                })
                ->addColumn('actions', function ($data) {

                    $userApproved = PCFApprover::where('p_c_f_request_id', $data->id)->where('done_by', auth()->user()->id)->where('approval_status', 1)->max('id');
                    $userDisapproved = PCFApprover::where('p_c_f_request_id', $data->id)->where('done_by', auth()->user()->id)->where('approval_status', 0)->max('id');
                    // $maxDisapprover = PCFApprover::where('p_c_f_request_id', $data->id)->where('done_by', '!=', auth()->user()->id)->where('approval_status', 0)->max('id');
                    // return $userApproved;
                    //with document uploaded
                    $uploadPcf = '<a href="'. route('PCF.edit', [$data->id]) .'" class="badge badge-info">
                                    <i class="fas fa-upload"></i> Upload Approved PCF</a>
                                <a target="_blank" href="#" class="badge badge-danger cancelPcfRequest" data-id="'.$data->id.'"
                                    rel="noopener noreferrer"> Cancel Request </a>
                                <a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';

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


                    //without document uploaded
                    $viewPcfPdfWithCancelRequest = '<a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-light" 
                                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>
                                    <a target="_blank" href="#" class="badge badge-danger cancelPcfRequest" data-id="'.$data->id.'"
                                    rel="noopener noreferrer"> Cancel Request </a>';

                    $viewPcfPdf = '<a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-light" 
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
                                    
                    $psrManagerButtons = '<a href="'. route('PCF.edit', [$data->id]) .'" class="badge badge-info">
                                    <i class="fas fa-edit"></i> Edit</a>
                                <a href="javascript:void(0);" class="badge badge-success approvePcfRequest" data-id="' . $data->id . '" data-toggle="modal">
                                    <i class="far fa-thumbs-up"></i> Approve</a>
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

                    if (!$data->is_cancelled) {
                        //for psr actions if cfo disapproved the request 
                        if (\Auth::user()->roles->pluck('name')->first() == 'PSR') {
                            if (!empty($data->pcf_document)) {
                                if (($data->is_cfo_approved !== null && $data->is_cfo_approved === 0) || ($data->is_accounting_approved !== null && $data->is_accounting_approved === 0)) {
                                    return $uploadedPcfwEditView;
                                } 
            
                                if ($data->is_cfo_approved === null || $data->is_accounting_approved === null) {
                                    return $viewPcfPdf;
                                }
                            } else {
                                if ($data->is_accounting_approved === 0 || $data->is_cfo_approved === 0) {
                                    //upload approved pcf 
                                    return $uploadPcf;
                                }
                                if ($data->is_cfo_approved === null || $data->is_accounting_approved === null) {
                                    return $viewPcfPdfWithCancelRequest;
                                }
                            }
                        }

                        if (\Auth::user()->roles->pluck('name')->first() == 'PSR Manager') {
                            if (!empty($data->pcf_document)) {
                                
                            } else {
                                if ($data->is_psr_manager_approved == 1 && $userApproved !== null) {
                                    return $viewPcfPdf;
                                }
                                if ($data->is_marketing_approved == 1 && $data->is_accounting_approved == 1 && $data->is_nsm_approved == 1 && $data->is_cfo_approved == 1) {
                                    return $viewPcfPdf;

                                } else if ($data->is_nsm_approved === 0 || $data->is_cfo_approved === 0 || $data->is_accounting_approved === 0) {
                                    return $psrManagerButtons;

                                } else if($data->is_psr_manager_approved === 0 || ($userApproved !== null || ($userDisapproved > $userApproved))) {
                                    return $psrManagerButtons;

                                }
                            }
                        }

                        if (\Auth::user()->roles->pluck('name')->first() == 'Marketing') {
                            if (!empty($data->pcf_document)) {
                                
                            } else {
                                if ($data->is_marketing_approved === null || $userApproved == null) {
                                    return $wEditApproval;

                                } else if ($data->is_marketing_approved === 0 || $userApproved == null) {
                                    return $wEditApproval;

                                } else if (($data->is_marketing_approved == 1 && $userApproved == null) || ($data->is_marketing_approved == 1 && ($userDisapproved > $userApproved))) {
                                    return $wEditApproval;

                                } else if ($data->is_marketing_approved == 1 && ($userApproved !== null || $userApproved > $userDisapproved)) {
                                    return $viewPcfPdf;
                                }
                            }
                        }    
                        
                        if (\Auth::user()->roles->pluck('name')->first() == 'Accounting') {
                            if (!empty($data->pcf_document)) {
                                
                            } else {
                                if ($data->is_accounting_approved === 1 ) {
                                    return $viewPcfPdf;
                                } else if ($data->is_accounting_approved === null && $userApproved == 0) {
                                    return $approval;
                                }
                            }
                        }   
                        
                        if (\Auth::user()->roles->pluck('name')->first() == 'National Sales Manager') {
                            if (!empty($data->pcf_document)) {
                                if ($data->is_nsm_approved === 1 && $data->is_cfo_approved === 0) {
                                    return $uploadedPcfWQuotationApproval;
                                }
                            } else {
                                if ($data->is_nsm_approved === 0 || $data->is_nsm_approved === null) {
                                    return $wEditQuotation;
                                } else if ($data->is_nsm_approved === 1) {
                                    return $wViewQuotation;
                                }
                            }
                        }  
                        
                        if (\Auth::user()->roles->pluck('name')->first() == 'Chief Finance Officer') {
                            if (!empty($data->pcf_document)) {
                                
                            } else {
                                if ($data->is_cfo_approved === 1) {
                                    return $wViewQuotation;
                                } else if ($data->is_cfo_approved === 0 || $data->is_cfo_approved === null) {
                                    return $uploadedPcfWQuotationApproval;
                                }
                            }
                        }  
                    } else {
                        return;
                    }
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }
    }

    public function cancelPcfRequest($pcfRequestId)
    {
        if ($pcfRequestId) {
            $cancelPcfRequest = PCFRequest::findOrFail($pcfRequestId);
            $cancelPcfRequest->is_cancelled = 1;
            $cancelPcfRequest->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'Unauthorized Access.'], 401);
    }

    public function pcfRequestDetails($pcfRequestId)
    {
        $this->authorize('pcf_request_access');

        $pcf_request = PCFRequest::findOrFail($pcfRequestId);
        
        return response()->json($pcf_request);
    }

    public function approvePcfRequest(Request $request)
    {
        if($request->ajax()) {
            $approvePcfRequest = new PCFApprover;
            $approvePcfRequest->p_c_f_request_id = $request->p_c_f_request_id;
            $approvePcfRequest->approval_status = 1;
            $approvePcfRequest->done_by = auth()->user()->id;
            $approvePcfRequest->remarks = ($request->remarks ? $request->remarks : '');
            $approvePcfRequest->save();

            if (\Auth::user()->roles->pluck('name')->first() == 'PSR Manager') {
                $psrManagerApprove = PCFRequest::findOrFail($request->p_c_f_request_id);
                $psrManagerApprove->is_psr_manager_approved = 1;
                $psrManagerApprove->save();

                return response()->json(['success' => 'success'], 200);
            }

            if (\Auth::user()->roles->pluck('name')->first() == 'Marketing') {
                $marketingApprove = PCFRequest::findOrFail($request->p_c_f_request_id);
                $marketingApprove->is_marketing_approved = 1;
                $marketingApprove->save();

                return response()->json(['success' => 'success'], 200);
            }

            if (\Auth::user()->roles->pluck('name')->first() == 'National Sales Manager') {
                $nsmApprove = PCFRequest::findOrFail($request->p_c_f_request_id);
                $nsmApprove->is_nsm_approved = 1;
                $nsmApprove->save();

                return response()->json(['success' => 'success'], 200);
            }

            if (\Auth::user()->roles->pluck('name')->first() == 'Accounting') {
                $accountingApprove = PCFRequest::findOrFail($request->p_c_f_request_id);
                $accountingApprove->is_accounting_approved = 1;
                $accountingApprove->save();

                return response()->json(['success' => 'success'], 200);
            }

            if (\Auth::user()->roles->pluck('name')->first() == 'Chief Finance Officer') {
                $cfoApprove = PCFRequest::findOrFail($request->p_c_f_request_id);
                $cfoApprove->is_cfo_approved = 1;
                $cfoApprove->save();

                return response()->json(['success' => 'success'], 200);
            }
        }
    }

    public function disapprovePcfRequest(Request $request)
    {
        if($request->ajax()) {
            $approvePcfRequest = new PCFApprover;
            $approvePcfRequest->p_c_f_request_id = $request->p_c_f_request_id;
            $approvePcfRequest->approval_status = 0;
            $approvePcfRequest->done_by = auth()->user()->id;
            $approvePcfRequest->remarks = ($request->remarks ? $request->remarks : '');
            $approvePcfRequest->save();

            if (\Auth::user()->roles->pluck('name')->first() == 'PSR Manager') {
                $psrManagerApprove = PCFRequest::findOrFail($request->p_c_f_request_id);
                $psrManagerApprove->is_psr_manager_approved = 0;
                $psrManagerApprove->save();

                return response()->json(['success' => 'success'], 200);
            }

            if (\Auth::user()->roles->pluck('name')->first() == 'Marketing') {
                $marketingApprove = PCFRequest::findOrFail($request->p_c_f_request_id);
                $marketingApprove->is_psr_manager_approved = null;
                $marketingApprove->is_marketing_approved = 0;
                $marketingApprove->save();

                return response()->json(['success' => 'success'], 200);
            }

            if (\Auth::user()->roles->pluck('name')->first() == 'National Sales Manager') {
                $nsmApprove = PCFRequest::findOrFail($request->p_c_f_request_id);
                $nsmApprove->is_psr_manager_approved = null;
                $nsmApprove->is_marketing_approved = null;
                $nsmApprove->is_nsm_approved = 0;
                $nsmApprove->save();

                return response()->json(['success' => 'success'], 200);
            }

            if (\Auth::user()->roles->pluck('name')->first() == 'Accounting') {
                $accountingApprove = PCFRequest::findOrFail($request->p_c_f_request_id);
                $accountingApprove->is_psr_manager_approved = null;
                $accountingApprove->is_marketing_approved = null;
                $accountingApprove->is_nsm_approved = null;
                $accountingApprove->is_cfo_approved = null;
                $accountingApprove->is_accounting_approved = 0;
                $accountingApprove->save();

                return response()->json(['success' => 'success'], 200);
            }

            if (\Auth::user()->roles->pluck('name')->first() == 'Chief Finance Officer') {
                $cfoApprove = PCFRequest::findOrFail($request->p_c_f_request_id);
                $cfoApprove->is_psr_manager_approved = null;
                $cfoApprove->is_marketing_approved = null;
                $cfoApprove->is_nsm_approved = null;
                $cfoApprove->is_accounting_approved = null;
                $cfoApprove->is_cfo_approved = 0;
                $cfoApprove->save();

                return response()->json(['success' => 'success'], 200);
            }
        }
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
                    'pcf_document' => $temporaryFile->file_name
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
        // $grandTotalGrossProfit = PCFList::where('pcf_no', $pcf_no)->sum('gross_profit');
        // $grandTotalCostPerYear = PCFInclusion::where('pcf_no', $pcf_no)->sum('cost_year');
        $grandTotalNetSales = PCFList::where('pcf_no', $pcf_no)->sum('total_net_sales'); //ito ung zero
        $getOpexTotal = PCFList::where('pcf_no', $pcf_no)->sum('opex');

        $annual_profit = $grandTotalNetSales - $getOpexTotal;

        // $annual_profit = $grandTotalGrossProfit - $grandTotalCostPerYear;
        
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

                'p_c_f_requests.supplier AS supplier',
                'p_c_f_requests.terms AS terms',
                'p_c_f_requests.validity AS validity',
                'p_c_f_requests.delivery AS delivery',
                'p_c_f_requests.warranty AS warranty',
                'p_c_f_requests.date_bidding AS date_bidding',
                'p_c_f_requests.bid_docs_price AS bid_docs_price',
                'users.name AS psr',
                'p_c_f_requests.manager AS manager',
                'p_c_f_requests.annual_profit AS annual_profit',
                'p_c_f_requests.annual_profit_rate AS annual_profit_rate',
            )
            ->leftJoin('p_c_f_requests','p_c_f_requests.pcf_no','p_c_f_lists.pcf_no')
            ->leftJoin('p_c_f_institutions', 'p_c_f_institutions.id', 'p_c_f_requests.institution_id')
            ->leftJoin('users','users.id','p_c_f_requests.created_by')
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

            $approver = PCFApprover::select(
                'p_c_f_approvers.done_by AS user_id',
                'users.name AS name',
                'users.department AS department'
            )
            ->leftJoin('users', 'users.id', 'p_c_f_approvers.done_by')
            ->where('users.department', 'Accounting')
            ->first();

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

                'p_c_f_requests.rfq_no AS rfq_no',
                'p_c_f_requests.created_at AS date',
                'p_c_f_requests.supplier AS supplier',
                'p_c_f_requests.terms AS terms',
                'p_c_f_requests.validity AS validity',
                'p_c_f_requests.delivery AS delivery',
                'p_c_f_requests.warranty AS warranty',

                'p_c_f_institutions.institution as institution',
                'p_c_f_institutions.address as institution_address',
                'p_c_f_institutions.contact_person as contact_person',
                'p_c_f_institutions.designation as designation',
                'p_c_f_institutions.thru_designation as thru_designation',

                'sources.item_code as item_code',
                'sources.description as description',
            )
            ->leftJoin('p_c_f_requests','p_c_f_requests.pcf_no','p_c_f_lists.pcf_no')
            ->join('sources', 'sources.id', 'p_c_f_lists.source_id')
            ->join('p_c_f_institutions', 'p_c_f_institutions.id', 'p_c_f_requests.institution_id')
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
