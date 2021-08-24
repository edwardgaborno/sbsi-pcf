<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PCFRequestController;
use App\Http\Controllers\PCFListController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\UserController;
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

    // PCF Index View
    Route::prefix('PCF')->group(function () {
        Route::name('PCF')->group(function () {
            Route::get('/', [PCFRequestController::class, 'index'])->name('');
            Route::get('/ajax/list', [PCFRequestController::class, 'index'])->name('.list');
            Route::post('/add', [PCFRequestController::class, 'store'])->name('.add');
            Route::post('/update', [PCFRequestController::class, 'update'])->name('.update');
            Route::get('/ajax/approve-request/{id}', [PCFRequestController::class, 'ApproveRequest'])->name('.enable');
            Route::get('/ajax/disapprove-request/{id}', [PCFRequestController::class, 'DisapproveRequest'])->name('.disable');
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
            Route::get('/ajax/get-descriptions/{item_code}', [PCFListController::class, 'getDescriptions'])->name('.get_descriptions'); 
            Route::get('/ajax/remove-added-item/{id}', [PCFListController::class, 'removeAddedItem'])->name('.remove_added_item');
            Route::get('/ajax/remove-added-inclusion/{id}', [PCFListController::class, 'removeAddedInclusion'])->name('.remove_added_inclusion');
            Route::get('/ajax/get-grand-totals/{pcf_no}', [PCFListController::class, 'getGrandTotals'])->name('.get_grand_totals');
        });
    });

    // user management
    Route::prefix('user-management/users')->group(function () {
        Route::name('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('');
            Route::get('/ajax/list', [UserController::class, 'index'])->name('.list');
            Route::post('/add', [UserController::class, 'store'])->name('.add');
            Route::post('/update', [UserController::class, 'update'])->name('.update');
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
            Route::get('/ajax/list', [SourceController::class, 'index'])->name('.list');
            Route::post('/add', [SourceController::class, 'store'])->name('.add');
            Route::post('/update', [SourceController::class, 'update'])->name('.update');
        });
    });

});

require __DIR__.'/auth.php';