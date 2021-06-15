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
        $user = auth('api')->user();

        if(isset($user)){

            return redirect('/');
        }
        return view('login');
    })->name('login-page');

    Route::post('', 'App\Http\Controllers\UserController@doLogin');
});

Route::get('logout', array('uses' => 'App\Http\Controllers\UserController@doLogout'));

//Route::get('/dashboard', 'App\Http\Controllers\SaleController@getDayTotalsByDateRange');
Route::get('/dashboard', function (){
    return view('dashboard');
});

Route::prefix('user')->group(function(){
    Route::get('', 'App\Http\Controllers\UserController@getUser');
});


