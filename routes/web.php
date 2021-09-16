<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PCFRequestController;
use App\Http\Controllers\PCFListController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FilepondController;
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
            Route::post('/pcf-document', [FilepondController::class, 'storePCFDocument'])->name('.pcf-document');
        });
    });

    // PCF Index View
    Route::prefix('PCF')->group(function () {
        Route::name('PCF')->group(function () {
            Route::get('/', [PCFRequestController::class, 'index'])->name('');
            Route::get('/ajax/list', [PCFRequestController::class, 'pcfList'])->name('.list');
            Route::get('/get/pcf_details={pcf_id}', [PCFRequestController::class, 'getPCFRequestDetails'])->name('.get-pcf-details');
            Route::post('/add', [PCFRequestController::class, 'store'])->name('.add');
            Route::put('/update', [PCFRequestController::class, 'update'])->name('.update');
            Route::get('/ajax/approve-request/{id}', [PCFRequestController::class, 'ApproveRequest'])->name('.enable');
            Route::get('/ajax/disapprove-request/{id}', [PCFRequestController::class, 'DisapproveRequest'])->name('.disable');
            Route::get('/download-pdf/{pcf_no}', [PCFRequestController::class, 'downloadPdf'])->name('.download_pdf');
            Route::get('/view-pdf/{pcf_no}', [PCFRequestController::class, 'viewPdf'])->name('.view_pdf');
            Route::post('/store-pcf-file', [PCFRequestController::class, 'storePCFPdfFile'])->name('.storeFile');
        });
    });

    // PCF Index View
    Route::prefix('PCF.sub')->group(function () {
        Route::name('PCF.sub')->group(function () {
            Route::get('/add-request', [PCFListController::class, 'show'])->name('.addrequest');
            Route::post('/add-items', [PCFListController::class, 'store'])->name('.additems');
            Route::post('/add-foc', [PCFListController::class, 'savefoc'])->name('.addfoc');
            Route::get('/ajax/list/{pcf_no?}', [PCFListController::class, 'index'])->name('.list');
            Route::get('/ajax/foc-list/{pcf_no?}', [PCFListController::class, 'getFocList'])->name('.foc_list');
            Route::get('/ajax/get-description/{id}', [PCFListController::class, 'getDescription'])->name('.get_description'); 
            Route::post('/ajax/get-descriptions/', [PCFListController::class, 'search'])->name('.get_descriptions'); 
            Route::get('/ajax/remove-added-item/{id}', [PCFListController::class, 'removeAddedItem'])->name('.remove_added_item');
            Route::get('/ajax/remove-added-inclusion/{id}', [PCFListController::class, 'removeAddedInclusion'])->name('.remove_added_inclusion');
            Route::get('/ajax/get-grand-totals/{pcf_no}', [PCFListController::class, 'getGrandTotals'])->name('.get_grand_totals');
        });
    });

    // user management
    Route::prefix('user-management/users')->group(function () {
        Route::name('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('');
            Route::get('/ajax/list', [UserController::class, 'usersList'])->name('.list');
            Route::post('/store', [UserController::class, 'store'])->name('.store');
            Route::put('/update', [UserController::class, 'update'])->name('.update');
            Route::get('/ajax/approve-user-account/{id}', [UserController::class, 'approveUser'])->name('.approve_user');
            Route::get('/ajax/enable-user-account/{id}', [UserController::class, 'enableUser'])->name('.enable_user');
            Route::get('/ajax/disable-user-account/{id}', [UserController::class, 'disableUser'])->name('.disable_user');
            Route::get('/ajax/delete-user-account/{id}', [UserController::class, 'destroy'])->name('.delete_user');
        });
    });

    // Source Index View
    Route::prefix('settings.source')->group(function () {
        Route::name('settings.source')->group(function () {
            Route::get('/', [SourceController::class, 'index'])->name('');
            Route::get('/ajax/source_list', [SourceController::class, 'sourceList'])->name('.list');
            Route::get('/get/source={source_id}', [SourceController::class, 'getSourceDetails'])->name('.get-source-details');
            Route::post('/store', [SourceController::class, 'store'])->name('.store');
            Route::put('/update', [SourceController::class, 'update'])->name('.update');
        });
    });

});

require __DIR__.'/auth.php';