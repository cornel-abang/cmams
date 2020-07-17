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
	//dd(Hash::make('@cmams22+'));
    return view('welcome');
});

Route::post('login', 'UserController@login')->name('login');

Route::group(['middleware'=>'auth:web'], function(){
	Route::group(['prefix'=>'admin'], function(){
		Route::get('dashboard', 'DashboardController@index')->name('dashboard');
	});
	Route::group(['prefix'=>'facility'], function(){
		Route::get('/', 'FacilityController@index')->name('facilities');
		Route::post('/', 'FacilityController@store')->name('add-facility');
		Route::get('edit/{id}', 'FacilityController@edit')->name('edit-facility');
		Route::post('edit/{id}', 'FacilityController@update');
		Route::get('destroy/{id}', 'FacilityController@destroy')->name('destroy');
	});
});
