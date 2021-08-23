<?php

namespace App\Http\Controllers;

use App\Models\PCFList;
use App\Models\PCFRequest;
use App\Models\PCFInclusion;
use App\Models\Source;
use Illuminate\Http\Request;
use Alert;
use Validator;
use Yajra\Datatables\Datatables;

class PCFListController extends Controller
{
    private $pcf_no;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $pcf_no)
    {
        if ($request->ajax()) {

            $getPCFList = PCFList::where('pcf_no', $pcf_no)->get();

            return Datatables::of($getPCFList)
                ->addIndexColumn()
                ->addColumn('pcf_no', function ($data) {
                    return $data->pcf_no;
                })
                ->addColumn('item_code', function ($data) {
                    return $data->item_code;
                })
                ->addColumn('description', function ($data) {
                    return $data->description;
                })
                ->addColumn('quantity', function ($data) {
                    return $data->quantity;
                })
                ->addColumn('sales', function ($data) {
                    return number_format($data->sales);
                })
                ->addColumn('total_sales', function ($data) {
                    return number_format($data->total_sales);
                })
                ->addColumn('action', function ($data) {
                    return
                        ' 
                    <td>
                        <a href="#" class="badge badge-danger"
                            data-id="' . $data->id . '"
                            onclick="removeAddedItem($(this))"><i
                                class="fas fa-trash-alt"></i> 
                            Remove
                        </a>
                    </td>
                    ';
                })
                ->escapeColumns([])
                ->make(true);
        }

    }

    public function getFocList(Request $request, $pcf_no)
    {
        if ($request->ajax()) {

            $getPCFInclusion = PCFInclusion::where('pcf_no', $pcf_no)->get();

            return Datatables::of($getPCFInclusion)
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
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pcf_no' => 'required|numeric',
            'item_code' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|numeric',
            'sales' => 'required|string',
            'total_sales' => 'required|string',
            'transfer_price' => 'required|string',
            'mandatory_peripherals' => 'required|string',
            'opex' => 'required|string',
            'net_sales' => 'required|string',
            'gross_profit' => 'required|string',
            'total_gross_profit' => 'required|string',
            'total_net_sales' => 'required|string',
            'profit_rate' => 'required|string',
        ]);

        if ($validator->passes()) {

            // Store Data in DATABASE from HERE 
            $savePCFList = new PCFList;
            $savePCFList->pcf_no = $request->pcf_no;
            $savePCFList->item_code = $request->item_code;
            $savePCFList->description = $request->description;
            $savePCFList->quantity = $request->quantity;
            $savePCFList->sales = $request->sales;
            $savePCFList->total_sales = $request->total_sales;
            $savePCFList->transfer_price = $request->transfer_price;
            $savePCFList->mandatory_peripherals = $request->mandatory_peripherals;
            $savePCFList->opex = $request->opex;
            $savePCFList->net_sales = $request->net_sales;
            $savePCFList->gross_profit = $request->gross_profit;
            $savePCFList->total_gross_profit = $request->total_gross_profit;
            $savePCFList->total_net_sales = $request->total_net_sales;
            $savePCFList->profit_rate = $request->profit_rate;
            $savePCFList->save();

            Alert::success('Items Saved', 'Added successfully');

            return response()->json(['success'=>'Added new records.']);
            
        }

        Alert::error('Invalid Data', $validator->errors()->first());

        return response()->json(['error'=>$validator->errors()]);
    }

    public function savefoc(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pcf_foc' => 'required',
            'item_code_foc' => 'required|string',
            'description_foc' => 'required|string',
            'serial_no_foc' => 'required|string',
            'type_foc' => 'required|string',
            'quantity_foc' => 'required|integer',
            'mandatory_peripherals_foc' => 'required|string',
            'opex_foc' => 'required|string',
            'total_cost_foc' => 'required|string',
            'depreciable_life_foc' => 'required|string',
            'cost_year_foc' => 'required|string'
        ]);

        if ($validator->passes()) {

            // Store Data in DATABASE from HERE 
            $savePCFInclusion = new PCFInclusion;
            $savePCFInclusion->pcf_no = $request->pcf_foc;
            $savePCFInclusion->item_code = $request->item_code_foc;
            $savePCFInclusion->description = $request->description_foc;
            $savePCFInclusion->serial_no = $request->serial_no_foc;
            $savePCFInclusion->type = $request->type_foc;
            $savePCFInclusion->quantity = $request->quantity_foc;
            $savePCFInclusion->mandatory_peripherals = $request->mandatory_peripherals_foc;
            $savePCFInclusion->opex = $request->opex_foc;
            $savePCFInclusion->total_cost = $request->total_cost_foc;
            $savePCFInclusion->depreciable_life = $request->depreciable_life_foc;
            $savePCFInclusion->cost_year = $request->cost_year_foc;
            $savePCFInclusion->save();

            Alert::success('Items Saved', 'Added successfully');

            return response()->json(['success'=>'Added new records.']);
            
        }

        Alert::error('Invalid Data', $validator->errors()->first());

        return response()->json(['error'=>$validator->errors()]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PCFList  $pCFList
     * @return \Illuminate\Http\Response
     */
    public function show(PCFList $pCFList)
    {
        //get max value of pcf number
        $getPcfMaxVal = PCFRequest::max('pcf_no');
        
        if(empty($getPcfMaxVal)) {
            $this->pcf_no = '000001';
        } else {
            $this->pcf_no = str_pad( $getPcfMaxVal+1, 6, "0", STR_PAD_LEFT );
        }

        // $grandTotalGrossProfit = PCFList::where('pcf_no', $this->pcf_no)->sum('gross_profit');
        // $grandTotalCostPerYear = PCFInclusion::where('pcf_no', $this->pcf_no)->sum('cost_year');
        // $grandTotalNetSales = PCFList::where('pcf_no', $this->pcf_no)->sum('total_net_sales');
        // $annual_profit = $grandTotalCostPerYear - $grandTotalGrossProfit;
        // $annual_profit_rate = $annual_profit / $grandTotalNetSales;

        return view('PCF.sub.addrequest',[
            'pcf_no' => $this->pcf_no,
            // 'total_gross_profit' => $totalGrossProfit,
            // 'grand_total_cost_per_year' => $grandTotalCostPerYear,
            // 'grand_total_net_sales' => $grandTotalNetSales
            // 'annual_profit' => $annual_profit,
            // 'annual_profit_rate' => $annual_profit_rate
        ]);
    }

    public function getDescription($id)
    {
        if (!empty($id)) {
            $getDescription = Source::find($id);
            return response()->json($getDescription);
        }
    }

    public function getDescriptions($item_code)
    {
        if (!empty($item_code)) {
            $getDescriptions = Source::find($item_code);
            return response()->json($getDescriptions);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PCFList  $pCFList
     * @return \Illuminate\Http\Response
     */
    public function edit(PCFList $pCFList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PCFList  $pCFList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PCFList $pCFList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PCFList  $pCFList
     * @return \Illuminate\Http\Response
     */
    public function destroy(PCFList $pCFList)
    {
        //
    }

    public function removeAddedItem($id)
    {
        if (!empty($id)) {
            $getAddedItem = PCFList::findOrFail($id);
            $getAddedItem->delete();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }

    public function removeAddedInclusion($id)
    {
        if (!empty($id)) {
            $getAddedInclusion = PCFInclusion::findOrFail($id);
            $getAddedInclusion->delete();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }

    public function getGrandTotals($pcf_no)
    {
        if (!empty($pcf_no)) {
           
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

        return response()->json(['error' => 'invalid'], 401);
    }
}
