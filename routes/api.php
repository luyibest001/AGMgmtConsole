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

Route::group(['middleware' => 'api', 'prefix' => 'auth/user'], function ($router) {
    Route::post('', 'App\Http\Controllers\UserController@doLogin')->name('login');
    Route::delete('', 'App\Http\Controllers\UserController@doLogout');
});


Route::group(['middleware' => 'jwt.verify'], function () {
    Route::prefix('auth/user')->group(function (){
        Route::delete('', 'App\Http\Controllers\UserController@doLogout');
        Route::put('', 'App\Http\Controllers\UserController@refresh');
        Route::get('', 'App\Http\Controllers\UserController@getUser');
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
});


