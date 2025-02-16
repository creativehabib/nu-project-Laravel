<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NuSmartCardController;
use App\Http\Controllers\RoutingController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::group(['prefix' => '/dashboard', 'middleware' => 'auth'], function () {
    Route::resource('nu-smart-card', DashboardController::class);
    Route::get('view-pdf', [DashboardController::class, 'getPdfData'])->name('view-pdf');

    Route::get('', [RoutingController::class, 'index'])->name('root');
    Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('{any}', [RoutingController::class, 'root'])->name('any');
});

// frontend route

Route::get('/nu-smart-card', [NuSmartCardController::class, 'index']);
Route::post('/nu-smart-card', [NuSmartCardController::class, 'store'])->name('nu-smart-card.store');
Route::get('/view-data', [NuSmartCardController::class, 'viewData'])->name('view-data');


