<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxController;


Route::get('/calculate', [TaxController::class, 'showForm']);
Route::post('/calculate', [TaxController::class, 'calculateTax']);
Route::delete('/calculate/{id}', [TaxController::class, 'deleteRecord'])->name('calculate.delete');