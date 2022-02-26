<?php

namespace App\Http\Controllers;

use App\Http\Requests\MandatoryPeripherals\StoreMandatoryPeripheralsRequest;
use App\Http\Requests\MandatoryPeripherals\UpdateMandatoryPeripheralsRequest;
use App\Http\Resources\MandatoryPeripheralResource;
use App\Models\MandatoryPeripheral;
use App\Models\MandatoryPeripheralCategory;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\Datatables\Datatables;

class MandatoryPeripheralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('mandatory_peripherals_access');

        $mpCategories = MandatoryPeripheralCategory::where('is_active', 1)->orderBy('id', 'ASC')->get();

        return view('settings.mandatory_peripherals.index', [
            'mpCategories' => $mpCategories,
        ]);
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
     * 
     */
    public function store(StoreMandatoryPeripheralsRequest $request)
    {
        $this->authorize('mandatory_peripherals_store');

        if (isset($request->validator) && $request->validator->fails()) {
            $errorMessage = $request->validator->messages();
            //set session to determine modal pop-up (Create modal or Edit modal)
            session(['store_errors' => $errorMessage]);

            return back()->withInput()->withErrors($errorMessage);
        }

        MandatoryPeripheral::create($request->validated());
        Alert::success('Success', 'Mandatory Peripheral has been added successfully.');

        return redirect()->route('settings.mandatory_peripheral.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MandatoryPeripheral  $mandatoryPeripheral
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $this->authorize('mandatory_peripherals_show');

        if ($request->ajax()) {

            $mp = MandatoryPeripheral::orderBy('id', 'DESC')->get();

            return Datatables::of($mp)
                ->addColumn('source_id', function($data) {
                    return $data->sources->item_code;
                })
                ->addColumn('category', function ($data) {
                    return $data->mandatoryPeripheralCategories->mp_category;
                })
                ->addColumn('status', function ($data) {
                    if ($data->is_active == 1) {
                        return '<span class="btn btn-sm btn-success">Active</span>';
                    }

                    return '<span class="btn btn-sm btn-danger">Inactive</span>';
                })
                ->addColumn('actions', function ($data) {
                    if (auth()->user()->can('mandatory_peripherals_edit')) {
                        if ($data->is_active == 1) {
                            return '<a href="javascript:void(0);" class="btn btn-sm btn-info edit-mp-modal" data-toggle="modal"
                                        data-id="' . $data->id . '"><i class="far fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-danger disable-mp"
                                        data-id="' . $data->id . '"><i class="fas fa-ban"></i> Disable</a>';
                        }

                        return '<a href="javascript:void(0);" class="btn btn-sm btn-info edit-mp-modal" data-toggle="modal"
                                        data-id="' . $data->id . '"><i class="far fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-success enable-mp"
                                        data-id="' . $data->id . '"><i class="far fa-check-circle"></i> Enable</a>';
                    }
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MandatoryPeripheral  $mandatoryPeripheral
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('mandatory_peripherals_edit');

        $editMp = MandatoryPeripheral::with('sources')->findOrFail($id);
        $mpAllDataForSelect2Edit = MandatoryPeripheral::with('sources')->get();

        if (!$editMp) {
            return response()->json(['message' => 'Not Found!'], 404);
        }

        return response()->json([
            'editMp' => $editMp,
            'mpAllDataForSelect2Edit' => $mpAllDataForSelect2Edit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MandatoryPeripheral  $mandatoryPeripheral
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMandatoryPeripheralsRequest $request)
    {
        $this->authorize('mandatory_peripherals_update');
        
        if (isset($request->validator) && $request->validator->fails()) {
            $errorMessage = $request->validator->messages();
            //set session to determine modal pop-up (Create modal or Edit modal)
            //retain mandatory peripheral id after validation error
            //retain mandatory peripheral category id after validation error
            session([
                'update_errors' => $request->mp_id,
            ]);

            return back()->withInput()->withErrors($errorMessage);
        }

        $updateMandatoryPeripheral = MandatoryPeripheral::findOrFail($request->mp_id);
        $updateMandatoryPeripheral->update($request->validated());

        Alert::success('Success', 'Mandatory Peripheral has been updated successfully.');
        
        return redirect()->route('settings.mandatory_peripheral.index');
    }

    public function enable($id)
    {
        if (!empty($id)) {
            $enableMp = MandatoryPeripheral::findOrFail($id);
            $enableMp->is_active = 1;
            $enableMp->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'Invalid Request!'], 401);
    }

    public function disable($id)
    {
        if (!empty($id)) {
            $disableMp = MandatoryPeripheral::findOrFail($id);
            $disableMp->is_active = 0;
            $disableMp->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'Invalid Request!'], 401);
    }

    public function getMandatoryPeripherals()
    {
        $mp = MandatoryPeripheral::where('is_active', 1)->orderBy('id', 'DESC')->get();
        return MandatoryPeripheralResource::collection($mp);
    }

    public function getSourceMandatoryPeripherals(Request $request, $id)
    {
        $this->authorize('source_access');
        if ($request->ajax()) {

            $ids = preg_split("/[,]/",$id);
            $sourceMandatoryPeripherals = MandatoryPeripheral::whereIn('id', $ids)->orderBy('id', 'DESC')->get();      

            return Datatables::of($sourceMandatoryPeripherals)
                ->addColumn('item_code', function ($data) {
                    return $data->sources->item_code;
                })
                ->addColumn('item_description', function ($data) {
                    return $data->item_description;   
                })
                ->addColumn('quantity', function ($data) {
                    return $data->quantity;
                })
                ->addColumn('item_category', function ($data) {
                    return $data->mpItemCategories->mp_category;
                })
                ->make(true);   
        }
    }

    public function getMandatoryTotalCostPeripherals(Request $request)
    {
        $this->authorize('mandatory_peripherals_access');
        $totalCostPeripherals = 0;
        if ($request->ids) {
            foreach ($request->ids as $id) {
                $getMandatoryUnitPrice = MandatoryPeripheral::where('id', $id)->first();
                $totalCostPeripherals += $getMandatoryUnitPrice->quantity * $getMandatoryUnitPrice->sources->unit_price;
            }
            return response()->json(['totalCostPeripherals' => $totalCostPeripherals], 202);
        }
        return response()->json(['error' => 'Invalid Request!'], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MandatoryPeripheral  $mandatoryPeripheral
     * @return \Illuminate\Http\Response
     */
    public function destroy(MandatoryPeripheral $mandatoryPeripheral)
    {
        //
    }
}
