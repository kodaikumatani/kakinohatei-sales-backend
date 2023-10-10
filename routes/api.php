<?php

use App\Http\Controllers\GetDateStoresController;
use App\Http\Controllers\GetSalesDailyController;
use App\Http\Controllers\GetSalesDailyDateController;
use App\Http\Controllers\GetSalesDailyDateProductsController;
use App\Http\Controllers\GetSalesDailyDateStoresController;
use App\Http\Controllers\GetSalesDateHourlyController;
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

Route::get('/{date}/stores', GetDateStoresController::class);
Route::get('/sales/daily', GetSalesDailyController::class);
Route::get('/sales/daily/{date}', GetSalesDailyDateController::class);
Route::get('/sales/daily/{date}/stores', GetSalesDailyDateStoresController::class);
Route::get('/sales/daily/{date}/products', GetSalesDailyDateProductsController::class);
Route::get('/sales/{date}/hourly', GetSalesDateHourlyController::class);
