<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\MainChartController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [MainChartController::class, 'index']);

Route::get('/esp-decider/{device}', [ApiController::class, 'decider']);