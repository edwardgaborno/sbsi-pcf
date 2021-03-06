<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PCFRequestController;
use App\Http\Controllers\PCFListController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FilepondController;
use App\Http\Controllers\PCFInclusionController;
use App\Http\Controllers\BundleProductController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\MandatoryPeripheralController;
use App\Http\Controllers\PCFApproverController;
use App\Http\Controllers\PCFInstitutionController;
use App\Http\Controllers\ProfitabilityPercentageController;
use App\Http\Controllers\SourceMandatoryPeripheralController;
use App\Http\Controllers\SupplierController;
use App\Models\MandatoryPeripheral;
use App\Models\PCFInstitution;
use App\Models\PCFRequest;
use App\Models\Price;
use App\Models\ProfitabilityPercentage;
use App\Models\SourceMandatoryPeripheral;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    //route for file upload feature for temporary location
    Route::prefix('tmp')->group(function (){
        Route::name('store')->group(function () {
            Route::post('/pcf-document', [FilepondController::class, 'storePCFDocument'])->name('.pcf_document');
        });
    });

    // PCF Index View
    Route::prefix('PCF')->group(function () {
        Route::name('PCF')->group(function () {
            Route::get('/', [PCFRequestController::class, 'index'])->name('.index');
            Route::get('/create-request', [PCFRequestController::class, 'create'])->name('.create_request');
            Route::get('/{p_c_f_request}/edit', [PCFRequestController::class, 'edit'])->name('.edit');
            Route::post('/store', [PCFRequestController::class, 'store'])->name('.store');
            Route::put('/{p_c_f_request}', [PCFRequestController::class, 'update'])->name('.update');

            Route::get('/ajax/list', [PCFRequestController::class, 'pcfRequestList'])->name('.list');
            Route::get('/ajax/items-list/{p_c_f_request}', [PCFListController::class, 'pcfRequestList'])->name('.items_list');
            Route::get('/ajax/inclusions-list/{p_c_f_request}', [PCFInclusionController::class, 'pcfRequestInclusion'])->name('.inclusions_list');

            Route::get('/get/pcf_details={p_c_f_request}', [PCFRequestController::class, 'pcfRequestDetails'])->name('.get-pcf-details');

            Route::get('/view-pdf/{pcf_no}', [PCFRequestController::class, 'viewPdf'])->name('.view_pdf');

            Route::get('/view-quotation/{pcf_no}', [PCFRequestController::class, 'viewQuotation'])->name('.view_quotation');

            Route::put('/{p_c_f_request}/upload', [PCFRequestController::class, 'storePCFPdfFile'])->name('.putFile');
            
            Route::post('/ajax/approve-pcf-request', [PCFRequestController::class, 'approvePcfRequest'])->name('.approve_pcf_request');
            Route::post('/ajax/disapprove-pcf-request', [PCFRequestController::class, 'disapprovePcfRequest'])->name('.disapprove_pcf_request');
            Route::get('/ajax/view-pcf-approvals/{id}', [PCFApproverController::class, 'index'])->name('.view_pcf_approvals');
            Route::get('/ajax/cancel-pcf-request/{id}', [PCFRequestController::class, 'cancelPcfRequest'])->name('.cancel_pcf_request');
        });
    });

    // PCF Index View
    Route::prefix('PCF.sub')->group(function () {
        Route::name('PCF.sub')->group(function () {
            Route::get('/ajax/item-list/{pcf_no}', [PCFListController::class, 'pcfItemList'])->name('.item_list');
            Route::get('/ajax/check-item/{pcf_no?}/{rfq_no?}/{source_id?}', [PCFListController::class, 'checkIfItemIsExist'])->name('.check_if_item_exist');
            Route::post('/ajax/count/{pcf_no}', [PCFListController::class, 'pcfItemCount'])->name('.item_count');
            Route::post('/store-items', [PCFListController::class, 'store'])->name('.store_items');
            Route::delete('/ajax/delete/pcf-list/{item_id}', [PCFListController::class, 'destroy'])->name('.destroy_item');

            Route::get('/ajax/foc-list/{pcf_no}', [PCFInclusionController::class, 'pcfFOCList'])->name('.foc_list');
            Route::post('/store-foc', [PCFInclusionController::class, 'store'])->name('.store_foc');
            Route::get('/ajax/check-inclusion/{pcf_no?}/{rfq_no?}/{source_id?}', [PCFInclusionController::class, 'checkIfInclusionIsExist'])->name('.check_if_inclusion_exist');
            Route::delete('/ajax/delete/pcf-foc/{foc_id}', [PCFInclusionController::class, 'destroy'])->name('.destroy_foc');

            Route::get('/ajax/bundled/item-list/{item_id}', [BundleProductController::class, 'pcfItemBundledProductLists'])->name('.bundled_item_lists');
            Route::get('/ajax/bundled/machines-list/{item_id}', [BundleProductController::class, 'pcfInclusionsBundledProductLists'])->name('.bundled_machine_lists');
            Route::post('/store/items-as-bundle/', [BundleProductController::class, 'store'])->name('.store_bundle_options');
            Route::delete('/ajax/delete/bundled-item/{item_id}', [BundleProductController::class, 'destroy'])->name('.destroy_bundle');

            Route::get('/ajax/get-grand-total/{pcf_no}', [PCFRequestController::class, 'getGrandTotal'])->name('.get_grand_total');
        });
    });

    // user management
    Route::prefix('user-management/users')->group(function () {
        Route::name('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('.index');
            Route::get('/create', [UserController::class, 'create'])->name('.create');
            Route::get('/ajax/users-list', [UserController::class, 'usersList'])->name('.list');
            Route::post('/store', [UserController::class, 'store'])->name('.store');
            Route::put('/update', [UserController::class, 'update'])->name('.update');
            Route::delete('/ajax/delete/account/{user_id}', [UserController::class, 'destroy'])->name('.delete');

            Route::get('/ajax/approve-user-account/{id}', [UserController::class, 'approveUser'])->name('.approve_user');
            Route::get('/ajax/enable-user-account/{id}', [UserController::class, 'enableUser'])->name('.enable_user');
            Route::get('/ajax/disable-user-account/{id}', [UserController::class, 'disableUser'])->name('.disable_user');
            Route::get('/details/{user_id}', [UserController::class, 'userDetails'])->name('.details');
        });
    });

    // settings/source
    Route::prefix('settings.source')->group(function () {
        Route::name('settings.source')->group(function () {
            Route::get('/', [SourceController::class, 'index'])->name('.index');
            Route::get('/create', [SourceController::class, 'create'])->name('.create');
            Route::get('/ajax/source-list/full', [SourceController::class, 'adminSourceList'])->name('.full_list');
            Route::get('/ajax/source-list/psr', [SourceController::class, 'psrSourceList'])->name('.psr_list');
            Route::post('/store', [SourceController::class, 'store'])->name('.store');
            Route::put('/update', [SourceController::class, 'update'])->name('.update');

            Route::get('/source/web/search/', [SourceController::class, 'sourceSearch'])->name('.source_search');
            Route::get('/get-details/source={source_id}', [SourceController::class, 'sourceDetails'])->name('.source_details');
            Route::get('/get-description/source={source_id}', [SourceController::class, 'sourceDescription'])->name('.source_description');

            Route::get('/ajax/get-source-list', [SourceController::class, 'getSources'])->name('.source_list');
            Route::get('/ajax/get-profit-rate-percentage/{id}', [ProfitabilityPercentageController::class, 'getProfitRatePercentage'])->name('.get_profit_rate_percentage');
            // Route::get('/ajax/view-mandatory-peripherals/{id}', [SourceMandatoryPeripheralController::class, 'index'])->name('.get_source_mandatory_peripherals');
            Route::get('/ajax/view-source-mandatory-peripherals/{id}', [MandatoryPeripheralController::class, 'getSourceMandatoryPeripherals'])->name('.get_source_mandatory_peripherals');
            Route::get('/ajax/get-source-suppliers/{id}', [SourceController::class, 'geSourceFilteredBySupplier'])->name('.get_source_filtered_by_supplier');
            Route::get('/ajax/get-cost-peripherals-total', [MandatoryPeripheralController::class, 'getMandatoryTotalCostPeripherals'])->name('.get_mandatory_total_cost_peripheral');
        });
    });

    // settings/Institution
    Route::prefix('settings.institution')->group(function () {
        Route::name('settings.institution')->group(function () {
            # get #########################################################################################################################################
            Route::get('/', [PCFInstitutionController::class, 'index'])->name('.index');
            Route::get('/get-institution-details/{institution_id}', [PCFInstitutionController::class, 'edit'])->name('.edit');
            Route::get('/ajax/institution-list', [PCFInstitutionController::class, 'show'])->name('.list');
            Route::get('/ajax/get-institutions-dropdown', [PCFInstitutionController::class, 'getInstitutionsForDropdown'])->name('.institution_list');
            Route::get('/ajax/enable-institution/{id}', [PCFInstitutionController::class, 'enableInstitution'])->name('.enable_institution');
            Route::get('/ajax/disable-institution/{id}', [PCFInstitutionController::class, 'disableInstitution'])->name('.disable_institution');
            # put #########################################################################################################################################
            Route::put('/update', [PCFInstitutionController::class, 'update'])->name('.update');
            # post #########################################################################################################################################
            Route::post('/store', [PCFInstitutionController::class, 'store'])->name('.store');
            Route::post('/store-address', [PCFInstitutionController::class, 'storeAddress'])->name('.store_address');
            Route::post('/get-institution-data', [PCFInstitutionController::class, 'getInsitutionData'])->name('.institution.data');
            Route::get('/get-institution-addresses/{search_key}', [PCFInstitutionController::class, 'getInstitutionAddresses'])->name('.addresses_list');

        });
    });

    //settings/department
    Route::prefix('settings/department')->name('settings.department.')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('index');
        Route::post('/', [DepartmentController::class, 'store'])->name('store');
        Route::get('/show/{id}', [DepartmentController::class, 'show'])->name('show');
    });

    //settings/profitablity-percentage
    Route::prefix('settings/profitability-percentage')->group(function () {
        Route::name('settings.profitability_percentage')->group(function () {
            # get ###################################################################################################################################
            Route::get('/', [ProfitabilityPercentageController::class, 'index'])->name('.index');
            Route::get('/profitability-percentage-list', [ProfitabilityPercentageController::class, 'show'])->name('.show');
            Route::get('/edit/{id}', [ProfitabilityPercentageController::class, 'edit'])->name('.edit');
            Route::get('/ajax/disable-profitability-percentage/{id}', [ProfitabilityPercentageController::class, 'disable'])->name('.disable');
            Route::get('/ajax/enable-profitability-percentage/{id}', [ProfitabilityPercentageController::class, 'enable'])->name('.enable');
            # post ##################################################################################################################################
            Route::post('/store', [ProfitabilityPercentageController::class, 'store'])->name('.store');
            # put ###################################################################################################################################
            Route::put('/update', [ProfitabilityPercentageController::class, 'update'])->name('.update');
        });
    });

    //settings/mandatory-peripherals
    Route::prefix('settings/mandatory-peripherals')->group(function () {
        Route::name('settings.mandatory_peripheral')->group(function () {
            # get ###################################################################################################################################
            Route::get('/', [MandatoryPeripheralController::class, 'index'])->name('.index');
            Route::get('/mandatory-peripherals-list', [MandatoryPeripheralController::class, 'show'])->name('.show');
            Route::get('/ajax/edit/{id}', [MandatoryPeripheralController::class, 'edit'])->name('.edit');
            Route::get('/ajax/disable-peripheral/{id}', [MandatoryPeripheralController::class, 'disable'])->name('.disable');
            Route::get('/ajax/enable-peripheral/{id}', [MandatoryPeripheralController::class, 'enable'])->name('.enable');
            Route::get('/ajax/get-mandatory-peripherals-dropdown', [MandatoryPeripheralController::class, 'getMandatoryPeripherals'])->name('.get_mandatory_peripherals');
            # post ##################################################################################################################################
            Route::post('/store', [MandatoryPeripheralController::class, 'store'])->name('.store');
            # put ###################################################################################################################################
            Route::put('/update', [MandatoryPeripheralController::class, 'update'])->name('.update');
        });
    });

    //business partners
    Route::prefix('business-partners/suppliers')->group(function () {
        Route::name('business_partners.supplier')->group(function () {
            # get ###################################################################################################################################
            Route::get('/', [SupplierController::class, 'index'])->name('.index');
            Route::get('/supplier-list', [SupplierController::class, 'show'])->name('.show');
            Route::get('/ajax/edit/{id}', [SupplierController::class, 'edit'])->name('.edit');
            Route::get('/ajax/disable-supplier/{id}', [SupplierController::class, 'disable'])->name('.disable');
            Route::get('/ajax/enable-supplier/{id}', [SupplierController::class, 'enable'])->name('.enable');
            Route::get('/ajax/get-suppliers-dropdown', [SupplierController::class, 'getSuppliersCollection'])->name('.getSuppliers');
            # post ##################################################################################################################################
            Route::post('/store', [SupplierController::class, 'store'])->name('.store');
            # put ###################################################################################################################################
            Route::put('/update', [SupplierController::class, 'update'])->name('.update');
        });
    });

    //settings department
    Route::prefix('settings/department')->name('settings.department.')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('index');
        Route::post('/', [DepartmentController::class, 'store'])->name('store');
        Route::get('/show/{id}', [DepartmentController::class, 'show'])->name('show');
    });

});

require __DIR__.'/auth.php';