<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $user = session('user');
    if(!isset($user)){
        return redirect()->route('login-page');
    }else{
        return view('index');
    }
})->name('home-page');

Route::prefix('login')->group(function () {
    Route::get('', function () {
        $user = session('user');
        \Log::info($user);
        if(isset($user)){
            return redirect('/');
        }
        return view('login');
    })->name('login-page');
});

Route::group(['prefix' => 'auth/user'], function ($router) {
    Route::post('', 'App\Http\Controllers\UserController@doLogin')->name('login');
    Route::delete('', 'App\Http\Controllers\UserController@doLogout');
    Route::get('', 'App\Http\Controllers\UserController@getUser');
});
