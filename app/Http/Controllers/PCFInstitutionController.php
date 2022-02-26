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
use App\Models\PCFAddress;
use App\Models\PCFInstitutionAddress;
use Illuminate\Support\Facades\Auth;
use DataTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use RealRashid\SweetAlert\Toaster;

class PCFInstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('institution_access');
        return view('business_partners.clients.index');
    }

    public function getInstitutionAddresses(Request $request, $search_query)
    {
        if ($request->ajax()) {
            $institutions = PCFInstitution::where('institution', 'like', '%'. $search_query. '%')->orderBy('id', 'DESC')->get();
            return Datatables::of($institutions)
                ->addColumn('status', function ($data) {
                    if ($data->is_active == 1) {
                        return '<span class="btn btn-sm btn-success">Active</span>';
                    }

                    return '<span class="btn btn-sm btn-danger">Inactive</span>';
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        return new JsonResponse(['message' => 'Whoops, something went wrong,'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInsitutionData(Request $request): JsonResponse {
        if ($request->wantsJson()) {
            $data = PCFInstitution::with('addresses')->whereHas('addresses', function (Builder $query) use ($request) {
                $query->where('p_c_f_institution_addresses.institution_id', $request->id);
            })
                ->first();
            return new JsonResponse(['data' => $data, 'message' => 'Retrieve successfully.'], Response::HTTP_OK);
        }
        return new JsonResponse(['message' => 'Whoops, something went wrong,'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Store a newly created resource in table of addresses.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function storeAddress(Request $request): JsonResponse {
    //     try {
    //         return DB::transaction(function () use ($request) {
    //             $address = PCFAddress::create(['address' => $request->address]);
    //             $address->institution()->sync(['institution_id' => $request->institution_id]);
    //             return new JsonResponse(['message' => 'Store address successfully.', 'data' => $address], Response::HTTP_CREATED);
    //         });
    //     } catch (\Exception $e) {
    //         return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
    //     }
    // }

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

        try {
            //modern way for transactional database query will rollback all queries automatically once failed.
            return DB::transaction(function () use ($request) { 
                $institution = PCFInstitution::create($request->validated());
                // $address = PCFAddress::create([
                //     'address' => $request->address
                // ]);
                // $institution->addresses()->sync(['address_id' => $address->id,]);
                Alert::success('Success', 'Institution has been added successfully.');

                return redirect()->route('settings.institution.index');
            });
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->route('settings.institution.index');
        }
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
            $institutions = PCFInstitution::orderBy('id', 'DESC')->get();

            return Datatables::of($institutions)
                ->addColumn('status', function ($data) {
                    if ($data->is_active == 1) {
                        return '<span class="btn btn-sm btn-success">Active</span>';
                    }

                    return '<span class="btn btn-sm btn-danger">Inactive</span>';
                })
                ->addColumn('actions', function ($data) {
                    if (auth()->user()->can('institution_edit')) {
                        if ($data->is_active == 1) {
                            return '<a href="javascript:void(0);" class="btn btn-sm btn-info edit-institution-modal" data-toggle="modal"
                                        data-id="' . $data->id . '"><i class="far fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-danger disable-institution"
                                        data-id="' . $data->id . '"><i class="fas fa-ban"></i> Disable</a>';
                        }

                        return '<a href="javascript:void(0);" class="btn btn-sm btn-info edit-institution-modal" data-toggle="modal"
                                        data-id="' . $data->id . '"><i class="far fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-success enable-institution"
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
        } catch (\Throwable $th) {
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
