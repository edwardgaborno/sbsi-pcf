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
        $this->authorize('psr_request_store');
        
        PCFInclusion::create($request->validated());

        alert()->success('Success','PCF Request FOC has been added.');

        return back();
    }

    public function pcfFOCList(Request $request, $pcf_no)
    {
        if ($request->ajax()) {

            $PCFInclusion = PCFInclusion::where('pcf_no', $pcf_no)->get();

            return Datatables::of($PCFInclusion)
                ->addIndexColumn()
                ->addColumn('item_code', function ($data) {
                    return $data->item_code;
                })
                ->addColumn('description', function ($data) {
                    return $data->description;
                })
                ->addColumn('serial_no', function ($data) {
                    return $data->serial_no;
                })
                ->addColumn('type', function ($data) {
                    return $data->type;
                })
                ->addColumn('quantity', function ($data) {
                    return $data->quantity;
                })
                ->addColumn('action', function ($data) {
                    if (auth()->user()->can('psr_delete')) {
                        return
                            ' 
                        <td>
                            <a href="#" class="badge badge-danger"
                                data-id="' . $data->id . '"
                                onclick="removeAddedInclusion($(this))"><i
                                    class="fas fa-trash-alt"></i> 
                                Remove
                            </a>
                        </td>
                        ';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

}
