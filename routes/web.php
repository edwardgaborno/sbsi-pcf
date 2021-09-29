<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PCFRequestController;
use App\Http\Controllers\PCFListController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FilepondController;
use App\Http\Controllers\PCFInclusionController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');



Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {

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
            Route::post('/store', [PCFRequestController::class, 'store'])->name('.store');
            Route::put('/update', [PCFRequestController::class, 'update'])->name('.update');

            Route::get('/ajax/list', [PCFRequestController::class, 'pcfRequestList'])->name('.list');
            Route::get('/ajax/items-list/{pcf_request_id}', [PCFListController::class, 'pcfRequestList'])->name('.items_list');
            Route::get('/ajax/inclusions-list/{pcf_request_id}', [PCFInclusionController::class, 'pcfRequestInclusion'])->name('.inclusions_list');

            Route::get('/get/pcf_details={pcf_request_id}', [PCFRequestController::class, 'pcfRequestDetails'])->name('.get-pcf-details');

            Route::get('/view-pdf/{pcf_no}', [PCFRequestController::class, 'viewPdf'])->name('.view_pdf');

            Route::get('/view-quotation/{pcf_no}', [PCFRequestController::class, 'viewQuotation'])->name('.view_quotation');

            Route::post('/store-pcf-file', [PCFRequestController::class, 'storePCFPdfFile'])->name('.storeFile');

            Route::get('/ajax/approve-request/{id}', [PCFRequestController::class, 'ApproveRequest'])->name('.enable');
            Route::get('/ajax/disapprove-request/{id}', [PCFRequestController::class, 'DisapproveRequest'])->name('.disable');
        });
    });

    // PCF Index View
    Route::prefix('PCF.sub')->group(function () {
        Route::name('PCF.sub')->group(function () {
            Route::get('/ajax/item-list/{pcf_no}', [PCFListController::class, 'pcfItemList'])->name('.item_list');
            Route::post('/store-items', [PCFListController::class, 'store'])->name('.store_items');
            Route::delete('/ajax/delete/pcf-list/{item_id}', [PCFListController::class, 'destroy'])->name('.destroy_item');

            Route::get('/ajax/foc-list/{pcf_no}', [PCFInclusionController::class, 'pcfFOCList'])->name('.foc_list');
            Route::post('/store-foc', [PCFInclusionController::class, 'store'])->name('.store_foc');
            Route::delete('/ajax/delete/pcf-foc/{foc_id}', [PCFInclusionController::class, 'destroy'])->name('.destroy_foc');

            Route::get('/ajax/get-grand-total/{pcf_no}', [PCFRequestController::class, 'getGrandTotal'])->name('.get_grand_total');
        });
    });

    // user management
    Route::prefix('user-management/users')->group(function () {
        Route::name('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('.index');
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

    // Source Index View
    Route::prefix('settings.source')->group(function () {
        Route::name('settings.source')->group(function () {
            Route::get('/', [SourceController::class, 'index'])->name('.index');
            Route::get('/ajax/source-list/full', [SourceController::class, 'adminSourceList'])->name('.full_list');
            Route::get('/ajax/source-list/psr', [SourceController::class, 'psrSourceList'])->name('.psr_list');
            Route::post('/store', [SourceController::class, 'store'])->name('.store');
            Route::put('/update', [SourceController::class, 'update'])->name('.update');

            Route::get('/source/web/search/', [SourceController::class, 'sourceSearch'])->name('.source_search');
            Route::get('/get-details/source={source_id}', [SourceController::class, 'sourceDescription'])->name('.source_description');
        });
    });

});

require __DIR__.'/auth.php';