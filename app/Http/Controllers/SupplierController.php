<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\Datatables\Datatables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('supplier_access');
        return view('business_partners.suppliers.index');
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
    public function store(StoreSupplierRequest $request)
    {
        $this->authorize('supplier_store');

        if (isset($request->validator) && $request->validator->fails()) {
            $errorMessage = $request->validator->messages();
            //set session to determine modal pop-up (Create modal or Edit modal)
            session(['store_errors' => $errorMessage]);

            return back()->withInput()->withErrors($errorMessage);
        }

        Supplier::create($request->validated());
        Alert::success('Success', 'Supplier has been added successfully.');

        return redirect()->route('business_partners.supplier.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $this->authorize('supplier_show');

        if ($request->ajax()) {
            $suppliers = Supplier::orderBy('id', 'DESC')->get();

            return Datatables::of($suppliers)
                ->addColumn('status', function ($data) {
                    if ($data->is_active == 1) {
                        return '<span class="btn btn-sm btn-success">Active</span>';
                    }

                    return '<span class="btn btn-sm btn-danger">Inactive</span>';
                })
                ->addColumn('actions', function ($data) {
                    if (auth()->user()->can('supplier_edit')) {
                        if ($data->is_active == 1) {
                            return '<a href="javascript:void(0);" class="btn btn-sm btn-info edit-supplier-modal" data-toggle="modal"
                                        data-id="' . $data->id . '"><i class="far fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-danger disable-supplier"
                                        data-id="' . $data->id . '"><i class="fas fa-ban"></i> Disable</a>';
                        }

                        return '<a href="javascript:void(0);" class="btn btn-sm btn-info edit-supplier-modal" data-toggle="modal"
                                        data-id="' . $data->id . '"><i class="far fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-success enable-supplier"
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
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('supplier_edit');

        $editSupplier = Supplier::findOrFail($id);
        if (!$editSupplier) {
            return response()->json(['message' => 'Not Found!'], 404);
        }

        return response()->json($editSupplier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request)
    {
        $this->authorize('supplier_update');
        if (isset($request->validator) && $request->validator->fails()) {
            $errorMessage = $request->validator->messages();
            //set session to determine modal pop-up (Create modal or Edit modal)
            //retain supplier id after validation error
            session([
                'update_errors' => $request->supplier_id,
            ]);

            return back()->withInput()->withErrors($errorMessage);
        }

        $updateSupplier = Supplier::findOrFail($request->supplier_id);
        $updateSupplier->update($request->validated());


        Alert::success('Success', 'Supplier has been updated successfully.');
        
        return redirect()->route('business_partners.supplier.index');
    }

    public function enable($id)
    {
        if (!empty($id)) {
            $enableSupplier = Supplier::findOrFail($id);
            $enableSupplier->is_active = 1;
            $enableSupplier->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'Invalid Request!'], 401);
    }

    public function disable($id)
    {
        if (!empty($id)) {
            $disableSupplier = Supplier::findOrFail($id);
            $disableSupplier->is_active = 0;
            $disableSupplier->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'Invalid Request!'], 401);
    }

    public function getSuppliersCollection()
    {
        $suppliers = Supplier::where('is_active', 1)->orderBy('supplier_name', 'ASC')->get();
        return SupplierResource::collection($suppliers);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
