<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------- 4-----------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes();
Route::get('/', function () {
    return view('welcome');
});
Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => ['auth']], function () {
//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('home', [
        'as'   => 'home',
        'uses' => 'HomeController@index',
    ]);
});

