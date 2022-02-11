<?php

namespace App\Http\Controllers;

use App\Http\Requests\PRofitabilityPercentage\StoreProfitabilityPercentageRequest;
use App\Http\Requests\ProfitabilityPercentage\UpdateProfitabilityPercentageRequest;
use App\Models\ItemCategory;
use App\Models\ProfitabilityPercentage;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class ProfitabilityPercentageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('profitability_percentages_access');
        $itemCategories = ItemCategory::where('is_active', 1)->orderBy('id', 'ASC')->get();

        return view('settings.profitability_percentages.index', [
            'item_categories' => $itemCategories,
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
     */
    public function store(StoreProfitabilityPercentageRequest $request)
    {
        $this->authorize('profitability_percentages_store');

        if (isset($request->validator) && $request->validator->fails()) {
            $errorMessage = $request->validator->messages();
            //set session to determine modal pop-up (Create modal or Edit modal)
            session(['store_errors' => $errorMessage]);

            return back()->withInput()->withErrors($errorMessage);
        }

        ProfitabilityPercentage::create($request->validated());
        Alert::success('Success', 'Profitability percentage has been added successfully.');

        return redirect()->route('settings.profitability_percentage.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProfitabilityPercentage  $profitabilityPercentage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $this->authorize('profitability_percentages_show');

        if ($request->ajax()) {
            $profitabilityPercentages = ProfitabilityPercentage::orderBy('id', 'DESC')->get();

            return Datatables::of($profitabilityPercentages)
                ->addColumn('item_category', function($data) {
                    return $data->itemCategory->category_name;
                })
                ->addColumn('percentage', function ($data) {
                    if(fmod($data->percentage, 1) !== 0.00){
                        // your code if its decimals has a value
                        return $data->percentage.'%';
                    } else {
                        // your code if the decimals are .00, or is an integer
                        return number_format($data->percentage, 0, '.', '').'%';
                    }
                })
                ->addColumn('status', function ($data) {
                    if ($data->is_active == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    }

                    return '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('actions', function ($data) {
                    if (auth()->user()->can('profitability_percentage_edit')) {
                        if ($data->is_active == 1) {
                            return '<a href="javascript:void(0);" class="badge badge-info edit-pricing-modal" data-toggle="modal"
                                        data-id="' . $data->id . '"><i class="far fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0);" class="badge badge-danger disable-pricing"
                                        data-id="' . $data->id . '"><i class="fas fa-ban"></i> Disable</a>';
                        }

                        return '<a href="javascript:void(0);" class="badge badge-info edit-pricing-modal" data-toggle="modal"
                                        data-id="' . $data->id . '"><i class="far fa-edit"></i> Edit</a>
                                    <a href="javascript:void(0);" class="badge badge-success enable-pricing"
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
     * @param  \App\Models\ProfitabilityPercentage  $profitabilityPercentage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('profitability_percentages_edit');

        $profitabilityPercentage = DB::table('profitability_percentages')
            ->leftJoin('item_categories', 'item_categories.id', '=', 'profitability_percentages.item_category_id')
            ->select('item_categories.*', 'profitability_percentages.*')
            ->where('profitability_percentages.id', $id)
            ->first();

        if (!$profitabilityPercentage) {
            return response()->json(['message' => 'Not Found!'], 404);
        }

        return response()->json($profitabilityPercentage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProfitabilityPercentage  $profitabilityPercentage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfitabilityPercentageRequest $request)
    {
        $this->authorize('profitability_percentages_update');
        if (isset($request->validator) && $request->validator->fails()) {
            $errorMessage = $request->validator->messages();
            //set session to determine modal pop-up (Create modal or Edit modal)
            //retain profit rate id after validation error
            session([
                'update_errors' => $request->profit_rate_id,
            ]);

            return back()->withInput()->withErrors($errorMessage);
        }

        $profitabilityPercentage = ProfitabilityPercentage::findOrFail($request->profit_rate_id);
        $profitabilityPercentage->update($request->validated() + [
            'item_category_id' => $request->item_category_id
        ]);


        Alert::success('Success', 'Profitability percentage has been updated successfully.');
        
        return redirect()->route('settings.profitability_percentage.index');
    }

    public function enable($id)
    {
        if (!empty($id)) {
            $profitabilityPercentage = ProfitabilityPercentage::findOrFail($id);
            $profitabilityPercentage->is_active = 1;
            $profitabilityPercentage->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'Invalid Request!'], 401);
    }

    public function disable($id)
    {
        if (!empty($id)) {
            $profitabilityPercentage = ProfitabilityPercentage::findOrFail($id);
            $profitabilityPercentage->is_active = 0;
            $profitabilityPercentage->save();

            return response()->json(['success' => 'success'], 200);
        }

        return response()->json(['error' => 'Invalid Request!'], 401);
    }

    public function getProfitRatePercentage($item_category_id)
    {
        $this->authorize('profitability_percentage_access');
        
        $percentage = DB::table('profitability_percentages')
            ->leftJoin('item_categories', 'item_categories.id', '=', 'profitability_percentages.item_category_id')
            ->select('item_categories.*', 'profitability_percentages.*')
            ->where('profitability_percentages.item_category_id', $item_category_id)
            ->first();

        if (!$percentage) {
            return response()->json([
                'message' => "Item category doesn't have profit rate yet!"  
            ], 404);
        }

        return response()->json($percentage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProfitabilityPercentage  $profitabilityPercentage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfitabilityPercentage $profitabilityPercentage)
    {
        //
    }
}
