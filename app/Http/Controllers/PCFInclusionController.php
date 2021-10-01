<?php

namespace App\Http\Controllers;

use App\Models\PCFInclusion;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\PCFInclusion\StorePCFInclusionRequest;

class PCFInclusionController extends Controller
{
    public function store(StorePCFInclusionRequest $request)
    {
        $this->authorize('pcf_request_store');
        
        PCFInclusion::create($request->validated() + [
            'p_c_f_request_id' => $request->p_c_f_request_id,
        ]);

        alert()->success('Success','The item has been added.');

        return back();
    }

    public function destroy($foc_id)
    {
        $pcfInclusion = PCFInclusion::findOrFail($foc_id);
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
                ->addColumn('action', function ($data) {
                    if (auth()->user()->can('pcf_request_delete')) {
                        return
                        '<a href="javascript:void(0)" class="badge badge-danger pcfInclusionDelete" data-id="' . $data->id . '">
                            <i class="fas fa-trash-alt"></i> Delete item</a>
                        ';
                    }
                })
                ->rawColumns(['action'])
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
                ->addColumn('action', function ($data) {
                    if (auth()->user()->can('pcf_request_delete')) {
                        return
                        '<a href="javascript:void(0)" class="badge badge-danger pcfInclusionDelete" data-id="' . $data->id . '">
                            <i class="fas fa-trash-alt"></i> Delete item</a>
                        ';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

}
