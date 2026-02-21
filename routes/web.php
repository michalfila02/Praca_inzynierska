<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\MainChartController;

Route::get('/', [MainChartController::class, 'index']);

use App\Http\Controllers\Api\ApiController;

Route::get('/esp-decider/{device}', [ApiController::class, 'decider']);