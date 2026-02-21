<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ApiController;

Route::get('/',  [ApiController::class, 'speaker']);
Route::post('/', [ApiController::class, 'reciver']);