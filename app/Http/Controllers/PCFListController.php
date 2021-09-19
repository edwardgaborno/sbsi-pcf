<?php

namespace App\Http\Controllers;

use App\Models\PCFList;
use App\Models\PCFRequest;
use App\Models\Source;
use Illuminate\Http\Request;
use Alert;
use Yajra\Datatables\Datatables;
use App\Http\Requests\PCFList\StorePCFListRequest;

class PCFListController extends Controller
{
    private $pcf_no;

    public function store(StorePCFListRequest $request)
    {
        $this->authorize('psr_request_store');
        
        PCFList::create($request->validated());

        alert()->success('Success','PCF Request Item has been added.');

        return back();
    }

    public function show(PCFList $pCFList)
    {
        //get max value of pcf number
        $getPcfMaxVal = PCFRequest::max('pcf_no');
        
        if(empty($getPcfMaxVal)) {
            $this->pcf_no = '000001';
        } else {
            $this->pcf_no = str_pad( $getPcfMaxVal + 1, 6, "0", STR_PAD_LEFT );
        }

        return view('PCF.sub.addrequest',[
            'pcf_no' => $this->pcf_no,
        ]);
    }

    public function destroy($item_id)
    {
        $this->authorize('psr_request_delete');

        $pcfList = PCFList::findOrFail($item_id);
        $pcfList->delete();

        return response()->json(['success' => 'success'], 200);
    }

    public function pcfItemList(Request $request, $pcf_no)
    {
        if ($request->ajax()) {
            $PCFList = PCFList::with('source')
                        ->select('p_c_f_lists.*')
                        ->where('pcf_no', $pcf_no)
                        ->get();

            return Datatables::of($PCFList)
                ->addColumn('sales', function ($data) {
                    return number_format($data->sales, 2, '.', ',');
                })
                ->addColumn('total_sales', function ($data) {
                    return number_format($data->total_sales, 2, '.', ',');
                })
                ->addColumn('action', function ($data) {
                    if (auth()->user()->can('psr_request_delete')) {
                        return
                        '<a href="javascript:void(0)" class="badge badge-danger pcfListDelete" data-id="' . $data->id . '">
                            <i class="fas fa-trash-alt"></i> Delete Item</a>
                        ';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
