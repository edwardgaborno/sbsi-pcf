<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Exception;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Source\StoreSourceRequest;
use App\Http\Requests\Source\UpdateSourceRequest;

class SourceController extends Controller
{
    public function index()
    {
        $this->authorize('source_access');
        
        return view('settings.source.index');
    }

    public function store(StoreSourceRequest $request)
    {
        $this->authorize('source_store');

        DB::beginTransaction();

        try {

            Source::create($request->validated());
            DB::commit();

            Alert::success('Success', 'Source details has been saved.');

        }
        catch (Exception $ex) {

            DB::rollBack();
            throw $ex; // use better error handling, for now this will do;
        }

        return back();
    }

    public function update(UpdateSourceRequest $request)
    {
        $this->authorize('source_update');

        DB::beginTransaction();

        try {

            $source = Source::findOrFail($request->source_id);
            $source->update($request->validated());
            
            DB::commit();

            Alert::success('Success', 'Source details has been updated.');

        }
        catch (Exception $ex) {

            DB::rollBack();
            throw $ex; // use better error handling, for now this will do;
        }

        return back();
    }

    public function sourceList(Request $request)
    {
        $this->authorize('source_access');

        if ($request->ajax()) {
            $sources = Source::orderBy('id', 'desc')->get();

            return Datatables::of($sources)
                ->addIndexColumn()
                ->addColumn('unit_price', function ($data) {
                    return number_format($data->unit_price, 2, '.', ',');
                })
                ->addColumn('tp_php', function ($data) {
                    return number_format($data->tp_php, 2, '.', ',');
                })
                ->addColumn('cost_of_peripherals', function ($data) {
                    return number_format($data->cost_of_peripherals, 2, '.', ',');
                })
                ->addColumn('actions', function ($data) {
                    return
                        '<a href="javascript:void(0);" class="badge badge-info editSourceDetails" data-toggle="modal"
                            data-id="'. $data->id .'">
                            <i class="far fa-edit"></i> Edit
                        </a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function getSourceDetails($source_id)
    {
        $this->authorize('source_access');
        
        $source = Source::findOrFail($source_id);
        return response()->json($source);
    }
}
