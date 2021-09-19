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
use Exception;
use App\Http\Requests\PCFRequest\StorePCFRequestRequest;
use App\Http\Requests\PCFRequest\UpdatePCFRequestRequest;

class PCFRequestController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('psr_request_access');
    
        return view('PCF.index');
    }

    public function store(StorePCFRequestRequest $request)
    {
        $this->authorize('psr_request_store');
        
        PCFRequest::create($request->validated() + [
            'psr' => auth()->user()->name,
            'created_by' => auth()->user()->id,
        ]);

        alert()->success('Success','PCF Request has been created.');

        return view('PCF.index');
    }

    public function update(UpdatePCFRequestRequest $request, PCFRequest $PCFRequest)
    {
        $this->authorize('psr_request_update');

        $updatePCFRequest = PCFRequest::findOrFail($request->pcf_request_id);
        $updatePCFRequest->update($request->validated() + [
            'psr' => auth()->user()->name,
        ]);

        Alert::success('PCF Request Details', 'Updated successfully'); 

        return redirect()->route('PCF');
    }

    public function pcfList(Request $request) 
    {
        $this->authorize('psr_request_access');

        if ($request->ajax()) {
            $PCFRequest = PCFRequest::orderBy('pcf_no')->get();

            return Datatables::of($PCFRequest)
                ->addIndexColumn()
                ->addColumn('actions', function ($data) {

                    if (empty($data->pcf_document)) {
                        $this->authorize('psr_request_edit');
                        return
                        ' 
                            <a href="#" class="badge badge-info editPCFRequest" 
                                data-id="' . $data->id . '"
                                data-toggle="modal">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                            <a target="_blank" href="' . route('PCF.download_pdf', $data->pcf_no) .'" 
                                class="badge badge-success" 
                                rel="noopener noreferrer">
                                <i class="far fa-file-pdf"></i>
                                Download PDF
                            </a>
                        ';
                    }
                    else {
                        $this->authorize('psr_request_edit');
                        return
                        ' 
                            <a href="#" class="badge badge-info editPCFRequest" 
                                data-id="' . $data->id . '"
                                data-toggle="modal">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                            <a target="_blank" href="' . route('PCF.download_pdf', $data->pcf_no) .'" 
                                class="badge badge-success" 
                                rel="noopener noreferrer">
                                <i class="far fa-file-pdf"></i>
                                Download PDF
                            </a>
                        ';
                    }
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function pcfRequestDetails($pcf_id)
    {
        $this->authorize('psr_request_access');

        $pcf_request = PCFRequest::findOrFail($pcf_id);
        
        return response()->json($pcf_request);
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
        $this->authorize('download_pcf');
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
            $pdf->setPaper('legal', 'portrait');
            return $pdf->stream('pcf_request.pdf', array("Attachment" => false));
        }

        //return bad request error
        return response()->json(['error' => 'invalid request'], 400);
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
}
