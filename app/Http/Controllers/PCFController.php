<?php

namespace App\Http\Controllers;

use App\Models\PCF;
use Illuminate\Http\Request;
use Alert;
use Validator;
use Yajra\Datatables\Datatables;

class PCFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $getSpecimenTypes = PCF::orderBy('name')->get();

            return Datatables::of($getSpecimenTypes)
                ->addIndexColumn()
                ->addColumn('id', function ($data) {
                    return $data->id;
                })
                ->addColumn('specimen_types', function ($data) {
                    return $data->name;
                })
                ->addColumn('description', function ($data) {
                    return $data->description;
                })
                ->addColumn('status', function ($data) {

                    if ($data->status == 1) {
                        $status = '<span class="badge badge-success">Enabled</span>';
                    } else {
                        $status = '<span class="badge badge-danger">Disabled</span>';
                    }

                    return $status;
                })
                ->addColumn('actions', function ($data) {

                    if ($data->status == 0) {

                        return
                            ' 
                    <td>
                        <a href="#" class="badge badge-info" data-toggle="modal"
                            data-id="'.$data->id .'"
                            data-name="'.$data->name .'"
                            data-description="'.$data->description .'"
                            data-target="#editSpecimenTypesModal"
                            onclick="editSpecimenTypes($(this))"><i
                                class="far fa-edit"></i> 
                            Edit</a>
                            <a href="#" class="badge badge-success"
                                data-id="' . $data->id . '"
                                onclick="enableSpecimen($(this))"><i
                                    class="fas fa-lock-open"></i> 
                            Enable</a>
                    </td>
                    ';
                    }

                    return
                        ' 
                    <td>
                        <a href="#" class="badge badge-info" data-toggle="modal"
                            data-id="'.$data->id .'"
                            data-name="'.$data->name .'"
                            data-description="'.$data->description .'"
                            data-target="#editSpecimenTypesModal"
                            onclick="editSpecimenTypes($(this))"><i
                                class="far fa-edit"></i> 
                            Edit</a>
                            <a href="#" class="badge badge-danger"
                                data-id="' . $data->id . '"
                                onclick="disableSpecimen($(this))"><i
                                    class="fas fa-lock"></i> Disable</a>
                    </td>
                    ';
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('PCF.index');
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
            'specimen_type' => 'required|string|unique:p_c_f_s,name',
            'description'   => 'nullable|string'
        ]);

        if ($validator->fails()) {
            Alert::error('Invalid Data', $validator->errors()->first()); //ignore the error it still works
            return redirect()->route('PCF');
        }

        $saveSpecimenTypes = new PCF;
        $saveSpecimenTypes->name = $request->specimen_type;
        $saveSpecimenTypes->description = $request->description;
        $saveSpecimenTypes->save();

        Alert::success('Specimen Types', 'Added successfully'); //ignore the error it still works

        return redirect()->route('PCF');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PCF  $specimenType
     * @return \Illuminate\Http\Response
     */
    public function show(PCF $PCF)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PCF  $specimenType
     * @return \Illuminate\Http\Response
     */
    public function edit(SpecimenType $specimenType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PCF  $specimenType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PCF $specimenType)
    {
        $validator = Validator::make($request->all(), [ //ignore this line error it still works
            'specimen_type_id' => 'required|numeric',
            'specimen_type' => 'required|string|unique:p_c_f_s,name,' . $request->specimen_type_id,
            'description'   => 'nullable|string'
        ]);

        if ($validator->fails()) {
            Alert::error('Invalid Data', $validator->errors()->first()); //ignore the error it still works
            return redirect()->route('PCF');
        }

        $updateSpecimenTypes = PCF::findOrFail($request->specimen_type_id);
        $updateSpecimenTypes->name = $request->specimen_type;
        $updateSpecimenTypes->description = $request->description;
        $updateSpecimenTypes->save();

        Alert::success('Specimen Types', 'Updated successfully'); //ignore the error it still works

        return redirect()->route('PCF');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PCF  $specimenType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PCF $specimenType)
    {
        //
    }

    public function enableSpecimenType($id)
    {

        if (!empty($id)) {
            $getSpecimenType = PCF::find($id);
            $getSpecimenType->status = 1;
            $getSpecimenType->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }

    public function disableSpecimenType($id)
    {

        if (!empty($id)) {
            $getSpecimenType = PCF::find($id);
            $getSpecimenType->status = 0;
            $getSpecimenType->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'invalid'], 401);
    }
}
