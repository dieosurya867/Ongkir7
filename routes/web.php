<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return redirect('/home');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/api/province/{id}/cities', 'HomeController@getCities');
Route::post('/store', 'HomeController@store')->name('store');

Route::post('/api/cities', 'HomeController@searchCities');

Auth::routes();
