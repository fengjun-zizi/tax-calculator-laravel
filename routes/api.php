<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaxApiController;
//use App\Http\Controllers\Api\TaxApiController;

//Route::post('/calculate-tax', [TaxApiController::class, 'calculate']);
Route::post('/calculate-tax', [TaxApiController::class, 'calculate']);