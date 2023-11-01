<?php

use App\Http\Controllers\GetHourlySalesByDateController;
use App\Http\Controllers\GetProductSalesByDateController;
use App\Http\Controllers\GetSalesByController;
use App\Http\Controllers\GetStoreSalesByDateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::pattern('date', '^([1-9][0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})$');

Route::get('/sales/daily/{date}', GetSalesByController::class);
Route::get('/sales/daily/{date}/stores', GetStoreSalesByDateController::class);
Route::get('/sales/daily/{date}/products', GetProductSalesByDateController::class);
Route::get('/sales/{date}/hourly', GetHourlySalesByDateController::class);
