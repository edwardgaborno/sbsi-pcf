<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Source;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {

        $sources = Source::orderBy('item_code')->get();
        // $testCodes = TestCode::orderBy('test_name')->where('status', 1)->get();
        // $specimen_types = SpecimenType::orderBy('name')->where('status', 1)->get();
        // $test_groups = TestGroup::orderBy('name')->where('status', 1)->get();
        // $machines = Machine::orderBy('name')->where('is_active', 1)->get();
        //dd($sources);
        
        View::share([
            'sources' => $sources
            // 'test_codes' => $testCodes,
            // 'specimen_types' => $specimen_types,
            // 'test_groups' => $test_groups,
            // 'machines' => $machines
        ]);
    }
}
