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
    return $request->user();

    Route::get('sales', 'App\Http\Controllers\SaleController@list');

    Route::get('sales/dayTotals', 'App\Http\Controllers\SaleController@getDayTotalsByDateRange');
});

Route::prefix('sales')->group(function () {
    Route::get('', 'App\Http\Controllers\SaleController@list');

    Route::get('dayTotals', 'App\Http\Controllers\SaleController@getByDateRange');
});

Route::prefix('employees')->group(function(){
    Route::get('', 'App\Http\Controllers\EmployeeController@list');
});

Route::prefix('products')->group(function(){
    Route::get('', 'App\Http\Controllers\ProductController@list');
});

Route::prefix('customers')->group(function(){
    Route::get('', 'App\Http\Controllers\CustomerController@list');
});

Route::prefix('user')->group(function(){
    Route::get('', 'App\Http\Controllers\UserController@getUser');
});


