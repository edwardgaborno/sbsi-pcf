<?php

namespace App\Http\Controllers;

use App\Models\PCFList;
use Illuminate\Http\Request;
use Alert;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Http\Requests\PCFList\StorePCFListRequest;

class PCFListController extends Controller
{
    public function store(StorePCFListRequest $request)
    {
        $this->authorize('pcf_request_store');

        DB::beginTransaction();

        try {

            $pcfList = PCFList::create($request->validated() + [
                'p_c_f_request_id' => $request->p_c_f_request_id,
            ]);

            $joins = DB::table('sources')
                    ->join('p_c_f_lists', 'sources.id', '=', 'p_c_f_lists.source_id')
                    ->select('sources.standard_price as standard_price', 'p_c_f_lists.sales as unit_price')
                    ->get();

            foreach($joins as $join) {
                $join->standard_price <= $join->unit_price ? $asp = 'YES' : $asp = 'NO';

                $pcfList->where('id', $pcfList->id)->update([
                    'above_standard_price' => $asp,
                ]);
            }

            DB::commit();
            alert()->success('Success','Item has been added');
        }
        catch (\Throwable $th) {

            DB::rollBack();
        }

        return back();
    }

    public function destroy($item_id)
    {
        $this->authorize('pcf_request_delete');

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
                    if (auth()->user()->can('pcf_request_delete')) {
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

    public function pcfRequestList(Request $request, $pcf_request_id)
    {
        if ($request->ajax()) {
            $pcfList = PCFList::with('source')
                        ->where('p_c_f_request_id', $pcf_request_id)
                        ->get();

            return Datatables::of($pcfList)
                ->addColumn('sales', function ($data) {
                    return number_format($data->sales, 2, '.', ',');
                })
                ->addColumn('total_sales', function ($data) {
                    return number_format($data->total_sales, 2, '.', ',');
                })
                ->addColumn('action', function ($data) {
                    if (auth()->user()->can('pcf_request_delete')) {
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
