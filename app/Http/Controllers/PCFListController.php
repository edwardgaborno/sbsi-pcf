<?php

namespace App\Http\Controllers;

use App\Models\PCFList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Http\Requests\PCFList\StorePCFListRequest;
use App\Models\PCFInclusion;
use App\Models\PCFRequest;
use App\Models\PCFRequestMandatoryItem;
use App\Models\PCFRequestMandatoryPeripheral;
use RealRashid\SweetAlert\Facades\Alert;

class PCFListController extends Controller
{
    public function store(StorePCFListRequest $request)
    {
        $this->authorize('pcf_request_store');
        DB::beginTransaction();

        try {

            $pcfList = PCFList::create($request->validated() + [
                'p_c_f_request_id' => $request->p_c_f_request_id,
                'rfq_no' => 'SAL.01.' . $request->rfq_no,
            ]);

            //check if added items has mandatory peripherals
            $checkIfItemHasMandatoryPeripherals = $pcfList->sources->mandatory_peripherals_ids;

            if ($checkIfItemHasMandatoryPeripherals) {
                //loop mandatory peripheral ids
                //save mandatory peripherals of added items with pcf no
                foreach($checkIfItemHasMandatoryPeripherals as $mandatoryIds) {
                    $pcfList->pcfMandatoryItems()->create($request->validated() + [
                        'mandatory_peripheral_id' => $mandatoryIds,
                    ]);
                }
            }

            if ($request->p_c_f_request_id) {
                $pcfRequest = PCFRequest::findOrFail($request->p_c_f_request_id);
                $pcfRequest->updated_by = auth()->user()->id;
                $pcfRequest->save();
            }

            $joins = DB::table('sources')
                    ->join('p_c_f_lists', 'sources.id', '=', 'p_c_f_lists.source_id')
                    ->select('sources.standard_price as standard_price', 'p_c_f_lists.sales as unit_price')
                    ->get();

            foreach($joins as $join) {
                $join->standard_price < $join->unit_price ? $asp = 'YES' : $asp = 'NO';

                $pcfList->where('id', $pcfList->id)->update([
                    'above_standard_price' => $asp,
                ]);
            }

            DB::commit();
        }
        catch (\Throwable $th) {
            info($th);
            DB::rollBack();
        }

        return back();
    }

    public function destroy($item_id)
    {
        $this->authorize('pcf_request_delete');

        $pcfList = PCFList::findOrFail($item_id);

        if ($pcfList->p_c_f_request_id !== null) {
            $pcfRequest = PCFRequest::findOrFail($pcfList->p_c_f_request_id);
            //update updated_by
            $pcfRequest->updated_by = auth()->user()->id;
            $pcfRequest->save();
        }

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
                ->addColumn('supplier', function($data) {
                    return $data->sources->suppliers->supplier_name;
                })
                ->addColumn('sales', function ($data) {
                    return number_format($data->sales, 2, '.', ',');
                })
                ->addColumn('total_sales', function ($data) {
                    return number_format($data->total_sales, 2, '.', ',');
                })
                ->addColumn('uom', function ($data) {
                    return optional($data->sources->unitOfMeasurements)->uom;
                })
                ->addColumn('above_standard_price', function($data) {
                    if ($data->above_standard_price == 'Yes') {
                        return '<span class="badge badge-success">Yes</span>';
                    }
                    return '<span class="badge badge-warning">No</span>';
                }) 
                ->addColumn('actions', function ($data) {
                    if (auth()->user()->can('pcf_request_delete')) {
                        return '
                            <a href="javascript:void(0)" class="pcfListDelete" data-id="' . $data->id . '">
                                <i class="fas fa-trash-alt text-danger"></i></a>';
                    }
                })
                ->rawColumns(['above_standard_price','actions'])
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
                ->addColumn('actions', function ($data) {
                    if (auth()->user()->can('pcf_request_delete')) {
                        return '<a href="javascript:void(0)" class="badge badge-primary pcfListCreateBundle" data-toggle="modal" data-id="' . $data->id . '">
                                    <i class="fas fa-box"></i> Bundle Items</a>
                                <a href="javascript:void(0)" class="badge badge-danger pcfListDelete" data-id="' . $data->id . '">
                                    <i class="fas fa-trash-alt"></i> Delete Item</a>';
                    }
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function getPcfListMandatoryItems(Request $request, $pcf_no)
    {
        if ($request->ajax()) {
            $pcfListMandatoryItems = PCFRequestMandatoryItem::where('pcf_no', $pcf_no)->get();

            return Datatables::of($pcfListMandatoryItems)
                ->addColumn('item_code', function ($data) {
                    return $data->mandatoryPeripheral->sources->item_code;
                })
                ->addColumn('item_description', function ($data) {
                    return $data->mandatoryPeripheral->sources->description;
                })
                ->addColumn('quantity', function ($data) {
                    return $data->pcfListItems->quantity * $data->mandatoryPeripheral->quantity;
                })
                ->addColumn('item_category', function ($data) {
                    return $data->mandatoryPeripheral->mpItemCategories->mp_category;
                })
                ->make(true);
        }
    }

    public function checkIfItemIsExist(Request $request)
    {
        if ($request->ajax()) {
            $checkIfExist = PCFList::where('pcf_no', $request->pcf_no)
                                    ->where('rfq_no', $request->rfq_no)
                                    ->where('source_id', $request->source_id)->count();
            if ($checkIfExist) {
                return response()->json([
                    'status' => 200,
                    'is_exist' => true,
                    'message' => "Item already existed in current item list, Do you want to proceed?",
                ]);
            }
        }
    }

    public function getGrandTotalProfit(Request $request, $pcf_no)
    {
        if ($request->ajax() && $pcf_no) {
            $sumTotalGrossProfit = 0.00;
            $sumTotalCostPerYear = 0.00;
            $sumTotalNetSales = 0.00;
            $sumTotalGrossProfit = PCFList::where('pcf_no', $pcf_no)->sum('total_gross_profit');
            $sumTotalCostPerYear = PCFInclusion::where('pcf_no', $pcf_no)->sum('cost_year');
            $sumTotalNetSales = PCFList::where('pcf_no', $pcf_no)->sum('total_net_sales');
            info($sumTotalNetSales);
            return response()->json([
                'sumTotalGrossProfit' => $sumTotalGrossProfit,
                'sumTotalCostPerYear' => $sumTotalCostPerYear,
                'sumTotalNetSales' => $sumTotalNetSales,
            ]);
        }
    }
}
