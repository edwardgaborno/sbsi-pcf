<?php

namespace App\Http\Controllers;

use App\Models\PCFInclusion;
use App\Models\PCFRequest;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\PCFInclusion\StorePCFInclusionRequest;

class PCFInclusionController extends Controller
{
    public function store(StorePCFInclusionRequest $request)
    {
        $this->authorize('pcf_request_store');
        
        PCFInclusion::create($request->validated() + [
            'p_c_f_request_id' => $request->p_c_f_request_id,
        ]);

        if ($request->p_c_f_request_id) {
            $pcfRequest = PCFRequest::findOrFail($request->p_c_f_request_id);
            $pcfRequest->updated_by = auth()->user()->id;
            $pcfRequest->save();
        }

        alert()->success('Success','Item has been added');

        return back();
    }

    public function destroy($foc_id)
    {
        $pcfInclusion = PCFInclusion::findOrFail($foc_id);

        if ($pcfInclusion->p_c_f_request_id !== null) {
            $pcfRequest = PCFRequest::findOrFail($pcfInclusion->p_c_f_request_id);
            //update updated_by
            $pcfRequest->updated_by = auth()->user()->id;
            $pcfRequest->save();
        }

        $pcfInclusion->delete();

        return response()->json(['success' => 'success'], 200);
    }

    public function pcfFOCList(Request $request, $pcf_no)
    {
        if ($request->ajax()) {
            $pcfInclusion = PCFInclusion::with('source')
                    ->select('p_c_f_inclusions.*')
                    ->where('pcf_no', $pcf_no)
                    ->get();

            return Datatables::of($pcfInclusion)
                ->addColumn('actions', function ($data) {
                    if (auth()->user()->can('pcf_request_delete')) {
                        return
                        '<a href="javascript:void(0)" class="badge badge-primary pcfInclusionsCreateBundle" data-toggle="modal" data-id="' . $data->id . '">
                            <i class="fas fa-box"></i> Bundle Items</a>
                        <a href="javascript:void(0)" class="pcfInclusionDelete" data-id="' . $data->id . '">
                            <i class="fas fa-trash-alt text-danger"></i></a>';
                    }
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function pcfRequestInclusion(Request $request, $pcf_request_id)
    {
        $this->authorize('pcf_request_access');

        if ($request->ajax()) {
            $pcfInclusion = PCFInclusion::with('source')
                        ->where('p_c_f_request_id', $pcf_request_id)
                        ->get();

            return Datatables::of($pcfInclusion)
                ->addColumn('actions', function ($data) {
                    if (auth()->user()->can('pcf_request_delete')) {
                        return
                        '<a href="javascript:void(0)" class="badge badge-primary pcfInclusionsCreateBundle" data-toggle="modal" data-id="' . $data->id . '">
                            <i class="fas fa-box"></i> Bundle Items</a>
                        <a href="javascript:void(0)" class="badge badge-danger pcfInclusionDelete" data-id="' . $data->id . '">
                            <i class="fas fa-trash-alt"></i> Delete item</a>';
                    }
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    function checkIfInclusionIsExist(Request $request)
    {
        if ($request->ajax()) {
            $checkIfExist = PCFInclusion::where('pcf_no', $request->pcf_no)
                                    ->where('rfq_no', $request->rfq_no)
                                    ->where('source_id', $request->source_id)->count();
            if ($checkIfExist) {
                return response()->json([
                    'status' => 200,
                    'is_exist' => true,
                    'message' => "Inclusion already existed in current list, Do you want to proceed?",
                ]);
            }
        }
    }

}
