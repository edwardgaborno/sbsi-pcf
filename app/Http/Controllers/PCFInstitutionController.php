<?php

namespace App\Http\Controllers;

use App\Models\PCFInstitution;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Institutions\StoreInstitutionRequest;
use App\Http\Requests\Institutions\UpdateInstitutionRequest;
use App\Http\Resources\InstitutionResource;

class PCFInstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('institution_access');
        
        return view('settings.institutions.index');
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
    public function store(StoreInstitutionRequest $request)
    {
        $this->authorize('institution_store');

        DB::beginTransaction();

        try {

            $dd = PCFInstitution::create($request->validated());
            DB::commit();

            Alert::success('Success', 'Institution has been added');

        }
        catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Error', 'Something went wrong! please contact your system administrator.');
        }

        return redirect()->route('settings.institution.index');
    }

    public function getInstitutionsForDropdown()
    {
        $institutions = PCFInstitution::where('is_active', 1)->orderBy('id', 'DESC')->get();
        return InstitutionResource::collection($institutions);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PCFInstitution  $pCFInstitution
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $this->authorize('source_access');

        if ($request->ajax()) {
            $instituions = PCFInstitution::orderBy('id', 'DESC')->get();

            return Datatables::of($instituions)
                ->addColumn('status', function($data) {
                    if ($data->is_active == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    }

                    return '<span class="badge badge-danger">Inactive</span>';
                    
                })
                ->addColumn('actions', function ($data) {
                    if(auth()->user()->can('institution_edit')) {
                        if ($data->is_active == 1) {
                            return '<a href="javascript:void(0);" class="badge badge-info edit-institution-modal" data-toggle="modal"
                                        data-id="'. $data->id .'"><i class="far fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0);" class="badge badge-danger disable-institution"
                                        data-id="'. $data->id .'"><i class="fas fa-ban"></i> Disable</a>';
                        }

                        return '<a href="javascript:void(0);" class="badge badge-info edit-institution-modal" data-toggle="modal"
                                        data-id="'. $data->id .'"><i class="far fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0);" class="badge badge-success enable-institution"
                                        data-id="'. $data->id .'"><i class="far fa-check-circle"></i> Enable</a>';
                    }
                })
                ->rawColumns(['status','actions'])
                ->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PCFInstitution  $pCFInstitution
     * @return \Illuminate\Http\Response
     */
    public function edit($institution_id)
    {
        $this->authorize('institution_access');
        
        $institution = PCFInstitution::find($institution_id);

        if (!$institution) {
            return response()->json(['message' => 'Not Found!'], 404);
        }

        return response()->json($institution);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PCFInstitution  $pCFInstitution
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstitutionRequest $request)
    {
        $this->authorize('institution_update');

        DB::beginTransaction();

        try {
            $institution = PCFInstitution::findOrFail($request->institution_id);
            $institution->update($request->validated());
            
            DB::commit();

            Alert::success('Success', 'Institution has been updated');

        }
        catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Error', 'Something went wrong! please contact your system administrator.');
        }

        return redirect()->route('settings.institution.index');
    }

    public function enableInstitution($institution_id)
    {
        if (!empty($institution_id)) {
            $institution = PCFInstitution::findOrFail($institution_id);
            $institution->is_active = 1;
            $institution->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'Invalid Request!'], 401);
    }

    public function disableInstitution($institution_id)
    {
        if (!empty($institution_id)) {
            $institution = PCFInstitution::findOrFail($institution_id);
            $institution->is_active = 0;
            $institution->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'Invalid Request!'], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PCFInstitution  $pCFInstitution
     * @return \Illuminate\Http\Response
     */
    public function destroy(PCFInstitution $pCFInstitution)
    {
        //
    }
}
