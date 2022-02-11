<?php

namespace App\Http\Controllers;

use App\Models\Source;
use App\Models\Supplier;
use App\Models\PCFList;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Source\StoreSourceRequest;
use App\Http\Requests\Source\UpdateSourceRequest;
use App\Http\Resources\SourceResource;
use App\Http\Resources\SupplierResource;
use App\Models\ItemCategory;
use App\Models\MandatoryPeripheral;
use App\Models\Segment;
use App\Models\SourceMandatoryPeripheral;
use App\Models\UnitOfMeasurement;

class SourceController extends Controller
{
    public function index()
    {
        $this->authorize('pcf_source_access');

        return view('settings.source.index');
    }

    public function create()
    {
        $this->authorize('source_create');

        $unitOfMeasurements = UnitOfMeasurement::where('is_active', 1)->orderBy('id', 'ASC')->get();
        $itemCategories = ItemCategory::where('is_active', 1)->orderBy('id', 'ASC')->get();
        $segments = Segment::where('is_active', 1)->orderBy('id', 'ASC')->get();

        return view('settings.source.create',  [
            'unitOfMeasurements' => $unitOfMeasurements,
            'itemCategories' => $itemCategories,
            'segments' => $segments,
        ]);
    }

    public function store(StoreSourceRequest $request)
    {

        $this->authorize('source_store');

        DB::beginTransaction();

        try {

            $saveSource = Source::create($request->validated() + [
                'supplier_id' => $request->supplier_id,
                'uom_id' => $request->oum_id,
                'segment_id' => $request->segment_id,
                'item_category_id' => $request->item_category_id
            ]);

            if ($request->mandatory_peripherals) {
                $saveSourceMandatoryPeripherals = new SourceMandatoryPeripheral;
                $saveSourceMandatoryPeripherals->source_id = $saveSource->id;
                $saveSourceMandatoryPeripherals->mandatory_peripheral_id = $request->mandatory_peripherals;
                $saveSourceMandatoryPeripherals->save();
            }

            DB::commit();
            Alert::success('Success', 'The source has been added');
        }
        catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Error', 'Something went wrong! please contact your system administrator.');
        }

        return redirect()->route('settings.source.index');
    }

    public function update(UpdateSourceRequest $request)
    {
        $this->authorize('source_update');

        DB::beginTransaction();

        try {
            $source = Source::findOrFail($request->source_id);
            $source->update($request->validated());

            $joins = DB::table('sources')
                    ->join('p_c_f_lists', 'sources.id', '=', 'p_c_f_lists.source_id')
                    ->select('sources.standard_price as standard_price', 'p_c_f_lists.sales as unit_price', 'p_c_f_lists.id as list_id')
                    ->get();

            foreach($joins as $join) {
                $pcfList = PCFList::where('id', $join->list_id);
                $join->standard_price <= $join->unit_price ? $asp = 'YES' : $asp = 'NO';

                $pcfList->update([
                    'above_standard_price' => $asp,
                ]);
            }
            
            DB::commit();

            Alert::success('Success', 'The source has been updated');

        }
        catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect()->route('settings.source.index');
    }
    private function formatNumber($value)
    {
        return number_format($value, 2, '.', ',');
    }

    public function adminSourceList(Request $request)
    {
        $this->authorize('source_access');
        // $sources = DB::table('sources')
        //             ->select(
        //                 'sources.id as id', 
        //                 'sources.item_code as item_code', 
        //                 'sources.description as description', 
        //                 'sources.unit_price as unit_price', 
        //                 'sources.currency_rate as currency_rate', 
        //                 'sources.tp_php as tp_php', 
        //                 'sources.cost_of_peripherals as cost_of_peripherals', 
        //                 'sources.standard_price as standard_price', 
        //                 'sources.profitability as profitability', 
        //                 'suppliers.supplier_name as supplier',
        //                 'segments.segment as segment',
        //                 'item_categories.category_name as item_category',
        //                 'source_mandatory_peripherals.source_id as source_id',
        //                 'source_mandatory_peripherals.mandatory_peripheral_id as mp_id',

        //                 // 'mandatory_peripherals.item_code as mp_item_code',
        //             )
        //             ->leftJoin('source_mandatory_peripherals', 'source_mandatory_peripherals.source_id','=', 'sources.id')
        //             // ->leftJoin('mandatory_peripherals', 'mandatory_peripherals.id','=', 'source_mandatory_peripherals.mandatory_peripheral_id')
        //             ->leftJoin('suppliers', 'suppliers.id', '=', 'sources.supplier_id')
        //             ->leftJoin('unit_of_measurements', 'unit_of_measurements.id', '=', 'sources.uom_id')
        //             ->leftJoin('segments', 'segments.id', '=', 'sources.segment_id')
        //             ->leftJoin('item_categories', 'item_categories.id', '=', 'sources.item_category_id')
        //             ->get();
        // dd($sources);
        if ($request->ajax()) {

            // $sources = DB::table('sources')
            //         ->select(
            //             'sources.id as id', 
            //             'sources.item_code as item_code', 
            //             'sources.description as description', 
            //             'sources.unit_price as unit_price', 
            //             'sources.currency_rate as currency_rate', 
            //             'sources.tp_php as tp_php', 
            //             'sources.cost_of_peripherals as cost_of_peripherals', 
            //             'sources.standard_price as standard_price', 
            //             'sources.profitability as profitability', 
            //             'suppliers.supplier_name as supplier',
            //             'unit_of_measurements.uom as uom',
            //             'segments.segment as segment',
            //             'item_categories.category_name as item_category',
            //             'source_mandatory_peripherals.source_id as source_id',
            //             'source_mandatory_peripherals.mandatory_peripheral_id as mp_id',

            //             // 'mandatory_peripherals.item_code as mp_item_code',
            //         )
            //         ->leftJoin('source_mandatory_peripherals', 'source_mandatory_peripherals.source_id','=', 'sources.id')
            //         // ->leftJoin('mandatory_peripherals', 'mandatory_peripherals.id','=', 'source_mandatory_peripherals.mandatory_peripheral_id')
            //         ->leftJoin('suppliers', 'suppliers.id', '=', 'sources.supplier_id')
            //         ->leftJoin('unit_of_measurements', 'unit_of_measurements.id', '=', 'sources.uom_id')
            //         ->leftJoin('segments', 'segments.id', '=', 'sources.segment_id')
            //         ->leftJoin('item_categories', 'item_categories.id', '=', 'sources.item_category_id')
            //         ->get();
            $soures = Source::all();

            return Datatables::of($sources)
                ->addIndexColumn()
                ->addColumn('supplier', function ($data) {
                    return $data->supplier;
                })
                ->addColumn('unit_price', fn($data) => $this->formatNumber($data->unit_price))
                ->addColumn('tp_php', function ($data) {
                    return number_format($data->tp_php, 2, '.', ',');
                })
                ->addColumn('uom', function ($data) {
                    if (empty($data->uom)) {
                        return 'None';
                    }
                    return $data->uom;
                })
                ->addColumn('segment', function ($data) {
                    if (empty($data->segment)) {
                        return 'None';
                    }
                    return $data->segment;
                })
                ->addColumn('item_category', function ($data) {
                    return $data->item_category;
                })
                ->addColumn('mandatory_peripherals', function ($data) {
                    $item_codes = [];
                    $mps = MandatoryPeripheral::where('id', $data->mp_id)->get();
                    if (!$mps->isEmpty()) {
                        foreach ($mps as $mp) {
                            array_push($item_codes, [
                                    'item_code' => $mp->item_code
                                ]
                            );//angulu ng dataase structure
                        }
                        return $item_codes;
                    } else {
                        return "None";
                    }
                })
                ->addColumn('cost_of_peripherals', function ($data) {
                    if (empty($data->cost_of_peripherals)) {
                        return 'None';
                    }
                    return number_format($data->cost_of_peripherals, 2, '.', ',');
                })
                ->addColumn('standard_price', function ($data) {
                    return number_format($data->standard_price, 2, '.', ',');
                })
                ->addColumn('actions', function ($data) {
                    if(auth()->user()->can('source_edit')) {
                        return
                        '<a href="javascript:void(0);" class="badge badge-info editSourceDetails" data-toggle="modal"
                            data-id="'. $data->id .'"><i class="far fa-edit"></i> Edit</a>';
                    }
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        // if ($request->ajax()) {

        //     $sources = Source::latest()
        //         ->select('id','item_code', 'description', 'unit_price', 'currency_rate', 'tp_php',
        //                 'mandatory_peripherals', 'cost_of_peripherals', 'standard_price', 'profitability')
        //         ->get();

        //     return Datatables::of($sources)
        //         ->addIndexColumn()
        //         ->addColumn('supplier', function ($data) {
        //             return $data->suppliers->supplier_name;
        //         })
        //         ->addColumn('unit_price', function ($data) {
        //             return number_format($data->unit_price, 2, '.', ',');
        //         })
        //         ->addColumn('tp_php', function ($data) {
        //             return number_format($data->tp_php, 2, '.', ',');
        //         })
        //         ->addColumn('uom', function ($data) {
        //             return $data->unitOfMeasurements->uom;
        //         })
        //         ->addColumn('segment', function ($data) {
        //             return $data->segments->segment;
        //         })
        //         ->addColumn('item_category', function ($data) {
        //             return $data->itemCategories->category_name;
        //         })
        //         ->addColumn('mandatory_peripherals', function ($data) {
        //             if (empty($data->mandatory_peripherals)) {
        //                 return "None";
        //             }
        //             return $data->mandatory_peripherals;
        //         })
        //         ->addColumn('cost_of_peripherals', function ($data) {
        //             if (empty($data->cost_of_peripherals)) {
        //                 return 'None';
        //             }
        //             return number_format($data->cost_of_peripherals, 2, '.', ',');
        //         })
        //         ->addColumn('standard_price', function ($data) {
        //             return number_format($data->standard_price, 2, '.', ',');
        //         })
        //         ->addColumn('actions', function ($data) {
        //             if(auth()->user()->can('source_edit')) {
        //                 return
        //                 '<a href="javascript:void(0);" class="badge badge-info editSourceDetails" data-toggle="modal"
        //                     data-id="'. $data->id .'"><i class="far fa-edit"></i> Edit</a>';
        //             }
        //         })
        //         ->rawColumns(['actions'])
        //         ->make(true);
        // }
    }

    public function psrSourceList(Request $request)
    {
        $this->authorize('source_access');

        if ($request->ajax()) {
            $sources = Source::select('supplier', 'item_code', 'description')->latest()->get();

            return Datatables::of($sources)
                ->make(true);
        }
    }

    public function getSources()
    {
        $sources = Source::orderBy('id', 'DESC')->get();
        return SourceResource::collection($sources);
    }

    public function sourceSearch(Request $request)
    {
        $this->authorize('source_access');

        $sources = Source::where('item_code', 'LIKE', '%'.$request->input('term', '').'%')
                        ->get(['id', 'item_code as text']);
        return ['results' => $sources];
    }

    public function sourceDetails($source_id)
    {
        $this->authorize('source_access');
        
        $source = Source::find($source_id);

        if (!$source) {
            return response()->json(['message' => 'Not Found!'], 404);
        }

        return response()->json($source);
    }

    public function sourceDescription($source_id)
    {
        $this->authorize('source_access');
        
        $source = Source::select('item_code', 'description', 'currency_rate', 'tp_php', 'cost_of_peripherals')->find($source_id);

        if (!$source) {
            return response()->json(['message' => 'Not Found!'], 404);
        }

        return response()->json($source);
    }
}
