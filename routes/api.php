<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    //return $request->user();
    Route::get('sales/dayTotals', 'App\Http\Controllers\SaleController@getDayTotalsByDateRange');
});

Route::prefix('sales')->group(function () {
    Route::get('dayTotals', 'App\Http\Controllers\SaleController@getDayTotalsByDateRange');

    Route::get('lastMonthDayTotals', 'App\Http\Controllers\SaleController@getLastMonth');
});

Route::prefix('user')->group(function(){
    Route::get('', 'App\Http\Controllers\UserController@getUser');
});


