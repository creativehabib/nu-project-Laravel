<?php

use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NuSmartCardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoutingController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

// Frontend
Route::get('/', [FrontEndController::class, 'index'])->name('home');
Route::prefix('jobs')->group(function () {
    Route::get('/apply_internal', [FrontEndController::class, 'apply_internal'])->name('apply_internal');
    Route::get('/apply', [FrontEndController::class, 'apply'])->name('apply');
    
});


Route::group(['prefix' => '/dashboard', 'middleware' => 'auth'], function () {

    // profile
    Route::resource('profile', ProfileController::class);

    Route::resource('nu-smart-card', DashboardController::class);
    Route::get('view-pdf', [DashboardController::class, 'getPdfData'])->name('view-pdf');
    Route::get('single-pdf/{id}', [DashboardController::class, 'getSinglePdfData'])->name('single-pdf');

    // Blood Group
    Route::resource('blood-group', BloodGroupController::class);
    Route::post('/blood-group/{id}/update-status', [BloodGroupController::class, 'updateStatus'])->name('blood-group.update-status');

    // Menu route
    Route::get('manage-menus',[MenuController::class, 'index'])->name('manage-menus');
    Route::post('create-menu',[MenuController::class, 'store'])->name('create-menu');


    Route::get('', [RoutingController::class, 'index'])->name('root');
    Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('{any}', [RoutingController::class, 'root'])->name('any');

});

// frontend route

Route::get('/nu-smart-card', [NuSmartCardController::class, 'index']);
Route::post('/nu-smart-card', [NuSmartCardController::class, 'store_data'])->name('nu-smart-card.store_data');
Route::get('/view-data', [NuSmartCardController::class, 'viewData'])->name('view-data');


