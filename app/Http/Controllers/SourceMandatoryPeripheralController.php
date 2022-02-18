<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use App\Models\MandatoryPeripheral;
use App\Models\MandatoryPeripheralCategory;
use App\Models\SourceMandatoryPeripheral;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class SourceMandatoryPeripheralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, $id)
    {
        $this->authorize('source_access');

        if ($request->ajax()) {
            $sourceMandatoryPeripherals = SourceMandatoryPeripheral::where('source_id', $id)->orderBy('created_at', 'desc')->get();          
            return Datatables::of($sourceMandatoryPeripherals)
                ->addColumn('item_code', function ($data) {
                    return $data->mandatoryPeripherals->item_code;
                })
                ->addColumn('item_description', function ($data) {
                    return $data->mandatoryPeripherals->item_description;   
                })
                ->addColumn('quantity', function ($data) {
                    return $data->mandatoryPeripherals->quantity;
                })
                ->addColumn('item_category', function ($data) {
                    $itemCategory = MandatoryPeripheralCategory::where('id', $data->mandatoryPeripherals->peripherals_category_id)->first();
                    return $itemCategory->mp_category;
                })
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SourceMandatoryPeripheral  $sourceMandatoryPeripheral
     * @return \Illuminate\Http\Response
     */
    public function show(SourceMandatoryPeripheral $sourceMandatoryPeripheral)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SourceMandatoryPeripheral  $sourceMandatoryPeripheral
     * @return \Illuminate\Http\Response
     */
    public function edit(SourceMandatoryPeripheral $sourceMandatoryPeripheral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SourceMandatoryPeripheral  $sourceMandatoryPeripheral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SourceMandatoryPeripheral $sourceMandatoryPeripheral)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SourceMandatoryPeripheral  $sourceMandatoryPeripheral
     * @return \Illuminate\Http\Response
     */
    public function destroy(SourceMandatoryPeripheral $sourceMandatoryPeripheral)
    {
        //
    }
}
