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

    public function pcfFOCList(Request $request)
    {
        if ($request->ajax()) {

            $PCFInclusion = PCFInclusion::with('source')
                    ->select('p_c_f_inclusions.*')
                    ->get();

            return Datatables::of($PCFInclusion)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if (auth()->user()->can('psr_request_delete')) {
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
