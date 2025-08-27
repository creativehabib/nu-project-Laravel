<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NuSmartCardController;

Route::get('/nu-smart-cards', [NuSmartCardController::class, 'index']);
