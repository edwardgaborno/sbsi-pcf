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

        $unitOfMeasurements = UnitOfMeasurement::where('is_active', 1)->orderBy('id', 'ASC')->get();
        $itemCategories = ItemCategory::where('is_active', 1)->orderBy('id', 'ASC')->get();
        $segments = Segment::where('is_active', 1)->orderBy('id', 'ASC')->get();

        return view('settings.source.index', [
            'unitOfMeasurements' => $unitOfMeasurements,
            'itemCategories' => $itemCategories,
            'segments' => $segments,
        ]);
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
               foreach ($request->mandatory_peripherals as $mp) {
                    $saveSourceMandatoryPeripherals = new SourceMandatoryPeripheral;
                    $saveSourceMandatoryPeripherals->source_id = $saveSource->id;
                    $saveSourceMandatoryPeripherals->mandatory_peripheral_id = $mp;
                    $saveSourceMandatoryPeripherals->save();
               }
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

        if ($request->ajax()) {

            $sources = Source::latest()
                ->select(
                    'id', 
                    'supplier_id',
                    'segment_id',
                    'uom_id',
                    'item_category_id',
                    'item_code', 
                    'description', 
                    'unit_price', 
                    'currency_rate', 
                    'tp_php',
                    'cost_of_peripherals', 
                    'standard_price', 
                    'profitability'
                    )
                ->get();

                return Datatables::of($sources)
                ->addIndexColumn()
                ->addColumn('supplier', function ($data) {
                    return $data->suppliers->supplier_name;
                })
                ->addColumn('unit_price', fn($data) => $this->formatNumber($data->unit_price))
                ->addColumn('tp_php', fn($data) => $this->formatNumber($data->tp_php))
                ->addColumn('uom', function ($data) {
                    if (empty($data->unitOfMeasurements->uom)) {
                        return 'None';
                    }
                    return $data->unitOfMeasurements->uom;
                })
                ->addColumn('segment', function ($data) {
                    if (empty($data->segments->segment)) {
                        return 'None';
                    }
                    return $data->segments->segment;
                })
                ->addColumn('item_category', function ($data) {
                    return $data->itemCategories->category_name;
                })
                ->addColumn('mandatory_peripherals', function ($data) {
                    return '<a href="#" data-toggle="modal" data-target="#view_mandatory_peripherals_modal" class="badge badge-primary view-mp-details" data-source_id="'.$data->id.'">View List</a>';
                })
                ->addColumn('cost_of_peripherals', fn($data) => $this->formatNumber($data->cost_of_peripherals))
                ->addColumn('standard_price', fn($data) => $this->formatNumber($data->standard_price))
                ->addColumn('actions', function ($data) {
                    if(auth()->user()->can('source_edit')) {
                        return
                        '<a href="javascript:void(0);" class="badge badge-info editSourceDetails" data-toggle="modal"
                            data-id="'. $data->id .'"><i class="far fa-edit"></i> Edit</a>';
                    }
                })
                ->rawColumns(['mandatory_peripherals','actions'])
                ->make(true);
        }
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
        
        // $source = Source::find($source_id);
        $source = DB::table('sources')
                    ->distinct()
                    ->select(
                        'sources.id as id', 
                        'sources.supplier_id as supplier_id', 
                        'sources.item_code as item_code', 
                        'sources.description as description',
                        'sources.unit_price as unit_price',
                        'sources.currency_rate as currency_rate',
                        'sources.tp_php as tp_php',
                        'sources.tp_php_less_tax as tp_php_less_tax',
                        'sources.uom_id as uom_id',
                        'sources.segment_id as segment_id',
                        'sources.item_category_id as item_category_id',
                        'sources.cost_of_peripherals as cost_of_peripherals',
                        'sources.standard_price as standard_price',
                        'sources.profitability as profitability',
                        'source_mandatory_peripherals.source_id as smp_source_id',
                        'source_mandatory_peripherals.mandatory_peripheral_id as mp_id',
                        'mandatory_peripherals.item_code as mp_item_code',
                    )
                    ->leftJoin('suppliers', 'suppliers.id', 'sources.supplier_id')
                    ->leftJoin('unit_of_measurements', 'unit_of_measurements.id', 'sources.uom_id')
                    ->leftJoin('segments', 'segments.id', 'sources.segment_id')
                    ->leftJoin('item_categories', 'item_categories.id', 'sources.item_category_id')
                    ->leftJoin('source_mandatory_peripherals', 'source_mandatory_peripherals.source_id', '=', 'sources.id')
                    ->leftJoin('mandatory_peripherals', 'mandatory_peripherals.id', 'source_mandatory_peripherals.mandatory_peripheral_id')
                    ->where('source_mandatory_peripherals.source_id', $source_id)
                        ->get();
        return response()->json($source);
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
