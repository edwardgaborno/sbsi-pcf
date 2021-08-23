<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;
use Alert;
use Validator;
use Yajra\Datatables\Datatables;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $getSource = Source::orderBy('id')->get();

            return Datatables::of($getSource)
                ->addIndexColumn()
                ->addColumn('id', function ($data) {
                    return $data->id;
                })
                ->addColumn('supplier', function ($data) {
                    return $data->supplier;
                })
                ->addColumn('item_code', function ($data) {
                    return $data->item_code;
                })
                ->addColumn('description', function ($data) {
                    return $data->description;
                })
                ->addColumn('unit_price', function ($data) {
                    return $data->unit_price;
                })
                ->addColumn('currency_rate', function ($data) {
                    return $data->currency_rate;
                })
                ->addColumn('tp_php', function ($data) {
                    return $data->tp_php;
                })
                ->addColumn('item_group', function ($data) {
                    return $data->item_group;
                })
                ->addColumn('uom', function ($data) {
                    return $data->uom;
                })
                ->addColumn('mandatory_peripherals', function ($data) {
                    return $data->mandatory_peripherals;
                })
                ->addColumn('cost_periph', function ($data) {
                    return $data->cost_periph;
                })
                ->addColumn('actions', function ($data) {
                    return
                        ' 
                    <td>
                        <a href="#" class="badge badge-info" data-toggle="modal"
                            data-id="'.$data->id .'"
                            data-supplier="'.$data->supplier .'"
                            data-item_code="'.$data->item_code .'"
                            data-description="'.$data->description .'"
                            data-unit_price="'.$data->unit_price .'"
                            data-currency_rate="'.$data->currency_rate .'"
                            data-tp_php="'.$data->tp_php .'"
                            data-item_group="'.$data->item_group .'"
                            data-uom="'.$data->uom .'"
                            data-mandatory_peripherals="'.$data->mandatory_peripherals .'"
                            data-cost_periph="'.$data->cost_periph .'"
                            data-target="#editSourceModal"
                            onclick="editSource($(this))"><i
                                class="far fa-edit"></i> 
                            Edit</a>
                    </td>
                    ';
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('settings.source.index');
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
        $validator = Validator::make($request->all(), [ //ignore this line error it still works
            'supplier' => 'required|string|unique:sources,supplier',
            'item_code'   => 'nullable|string',
            'description'   => 'nullable|string',
            'unit_price'   => 'nullable|string',
            'currency_rate'   => 'nullable|string',
            'tp_php'   => 'nullable|string',
            'item_group'   => 'nullable|string',
            'uom'   => 'nullable|string',
            'mandatory_peripherals'   => 'nullable|string',
            'cost_periph'   => 'nullable|string'
        ]);

        if ($validator->fails()) {
            Alert::error('Invalid Data', $validator->errors()->first()); //ignore the error it still works
            return view('settings.source.index');
        }

        $saveSource = new Source;
        $saveSource->supplier = $request->supplier;
        $saveSource->item_code = $request->item_code;
        $saveSource->description = $request->description;
        $saveSource->unit_price = $request->unit_price;
        $saveSource->currency_rate = $request->currency_rate;
        $saveSource->tp_php = $request->tp_php;
        $saveSource->item_group = $request->item_group;
        $saveSource->uom = $request->uom;
        $saveSource->mandatory_peripherals = $request->mandatory_peripherals;
        $saveSource->cost_periph = $request->cost_periph;
        $saveSource->save();

        Alert::success('Source Details', 'Added successfully'); //ignore the error it still works

        return view('settings.source.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function show(Source $source)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function edit(Source $source)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Source $source)
    {
        $validator = Validator::make($request->all(), [ //ignore this line error it still works
            'id' => 'required|numeric',
            'supplier' => 'required|string|unique:sources,supplier,'. $request->id,
            'item_code'   => 'nullable|string',
            'description'   => 'nullable|string',
            'unit_price'   => 'nullable|string',
            'currency_rate'   => 'nullable|string',
            'tp_php'   => 'nullable|string',
            'item_group'   => 'nullable|string',
            'uom'   => 'nullable|string',
            'mandatory_peripherals'   => 'nullable|string',
            'cost_periph'   => 'nullable|string'
        ]);

        if ($validator->fails()) {
            Alert::error('Invalid Data', $validator->errors()->first()); //ignore the error it still works
            return view('settings.source.index');
        }

        $updateSource = Source::findOrFail($request->id);
        $updateSource->supplier = $request->supplier;
        $updateSource->item_code = $request->item_code;
        $updateSource->description = $request->description;
        $updateSource->unit_price = $request->unit_price;
        $updateSource->currency_rate = $request->currency_rate;
        $updateSource->tp_php = $request->tp_php;
        $updateSource->item_group = $request->item_group;
        $updateSource->uom = $request->uom;
        $updateSource->mandatory_peripherals = $request->mandatory_peripherals;
        $updateSource->cost_periph = $request->cost_periph;
        $updateSource->save();

        Alert::success('Source Details', 'Updated successfully'); //ignore the error it still works

        return view('settings.source.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function destroy(Source $source)
    {
        //
    }
}
