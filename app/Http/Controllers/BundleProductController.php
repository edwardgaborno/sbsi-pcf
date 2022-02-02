<?php

namespace App\Http\Controllers;

use App\Models\BundleProduct;
use App\Models\PCFList;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\BundleProduct\StoreBundleProductsRequest;

class BundleProductController extends Controller
{
    public function store(StoreBundleProductsRequest $request)
    {
        $this->authorize('pcf_request_store');

        $bundledItem = BundleProduct::create($request->validated() + [
            'p_c_f_list_id' => $request->p_c_f_list_id,
            'p_c_f_inclusion_id' => $request->p_c_f_inclusion_id
        ]);

        //update item list is_bundled = true after saving item to bundle product/item
        if ($bundledItem) {
            $pcfList = PCFList::findOrFail($request->p_c_f_list_id);
            $pcfList->is_bundled = true;
            $pcfList->save();
        }

    }

    public function destroy($item_id)
    {
        $this->authorize('pcf_request_delete');

        $bundledProduct = BundleProduct::findOrFail($item_id);

        //check if there's still items bundled to the PCFList
        $checkIfItemHasMoreBundled = BundleProduct::where('p_c_f_list_id', $bundledProduct->p_c_f_list_id)->where('id','!=', $item_id)->count();

        if (!$checkIfItemHasMoreBundled > 0) {
            // update PCFList bundle status as not bundled
            $updatePcfListItem = PCFList::findOrFail($bundledProduct->p_c_f_list_id);
            $updatePcfListItem->is_bundled = false;
            $updatePcfListItem->save();
        }

        $bundledProduct->delete();

        return response()->json(['success' => 'success'], 200);
    }

    public function pcfItembundledProductLists(Request $request, $item_id)
    {
        if ($request->ajax()) {
            $bundledProduct = BundleProduct::with('source')
                        ->select('bundle_products.*')
                        ->where('p_c_f_list_id', $item_id)
                        ->get();

            return Datatables::of($bundledProduct)
                ->addColumn('actions', function ($data) {
                    if (auth()->user()->can('pcf_request_delete')) {
                        return '
                            <a href="javascript:void(0)" class="pcfListBundleDelete" data-id="' . $data->id . '">
                                <i class="fas fa-trash-alt text-danger"></i></a>';
                    }
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function pcfInclusionsBundledProductLists(Request $request, $item_id)
    {
        if ($request->ajax()) {
            $bundledProduct = BundleProduct::with('source')
                        ->select('bundle_products.*')
                        ->where('p_c_f_inclusion_id', $item_id)
                        ->get();

            return Datatables::of($bundledProduct)
                ->addColumn('actions', function ($data) {
                    if (auth()->user()->can('pcf_request_delete')) {
                        return '
                            <a href="javascript:void(0)" class="pcfInclusionBundleDelete" data-id="' . $data->id . '">
                                <i class="fas fa-trash-alt text-danger"></i></a>';
                    }
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }
}
