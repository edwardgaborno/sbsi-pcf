<?php

namespace App\Http\Controllers;

use App\Models\Source;
use App\Models\PCFList;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Source\StoreSourceRequest;
use App\Http\Requests\Source\UpdateSourceRequest;
use App\Http\Resources\SourceResource;

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

        return view('settings.source.create');
    }

    public function store(StoreSourceRequest $request)
    {
        $this->authorize('source_store');
        DB::beginTransaction();

        try {

            Source::create($request->validated());
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

    public function adminSourceList(Request $request)
    {
        $this->authorize('source_access');

        if ($request->ajax()) {
            $sources = Source::latest()
                ->select('id', 'supplier', 'item_name', 'item_code', 'description', 'unit_price', 'currency_rate', 'tp_php', 'item_group', 'uom',
                        'mandatory_peripherals', 'cost_of_peripherals', 'segment', 'item_category', 'standard_price', 'profitability')
                ->get();

            return Datatables::of($sources)
                ->addIndexColumn()
                ->addColumn('unit_price', function ($data) {
                    return number_format($data->unit_price, 2, '.', ',');
                })
                ->addColumn('tp_php', function ($data) {
                    return number_format($data->tp_php, 2, '.', ',');
                })
                ->addColumn('item_group', function ($data) {
                    if (empty($data->item_group)) {
                        return "None";
                    }
                    return $data->item_group;
                })
                ->addColumn('uom', function ($data) {
                    if (empty($data->uom)) {
                        return "None";
                    }
                    return $data->uom;
                })
                ->addColumn('segment', function ($data) {
                    if (empty($data->segment)) {
                        return "None";
                    }
                    return $data->segment;
                })
                ->addColumn('mandatory_peripherals', function ($data) {
                    if (empty($data->mandatory_peripherals)) {
                        return "None";
                    }
                    return $data->mandatory_peripherals;
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
    }

    public function psrSourceList(Request $request)
    {
        $this->authorize('source_access');

        if ($request->ajax()) {
            $sources = Source::select('supplier', 'item_name', 'item_code', 'description')->latest()->get();

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
