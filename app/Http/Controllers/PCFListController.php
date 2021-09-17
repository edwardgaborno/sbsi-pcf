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

    public function sourceSearch(Request $request)
    {
        $this->authorize('psr_request_access');

        $sources = Source::where('item_code', 'LIKE', '%'.$request->input('term', '').'%')
                        ->get(['id', 'item_code as text']);
        return ['results' => $sources];
    }

    public function pcfItemList(Request $request)
    {
        if ($request->ajax()) {

            $PCFList = PCFList::with('source')
                        ->select('p_c_f_lists.*')
                        ->get();

            return Datatables::of($PCFList)
                ->addIndexColumn()
                ->addColumn('sales', function ($data) {
                    return number_format($data->sales, 2, '.', ',');
                })
                ->addColumn('total_sales', function ($data) {
                    return number_format($data->total_sales, 2, '.', ',');
                })
                ->addColumn('action', function ($data) {
                    if (auth()->user()->can('psr_request_delete')) {
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
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
