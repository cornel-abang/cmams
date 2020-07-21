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
})->name('home');

Route::get('login', function(){
	return view('welcome');
});
Route::post('login', 'UserController@login')->name('login');

Route::group(['middleware'=>'auth:web'], function(){
	Route::group(['prefix'=>'admin'], function(){
		Route::get('dashboard', 'DashboardController@index')->name('dashboard');
	});
	Route::group(['prefix'=>'facilities'], function(){
		Route::get('/', 'FacilityController@index')->name('facilities');
		Route::post('/', 'FacilityController@store')->name('add-facility');
		Route::get('edit/{id}', 'FacilityController@edit')->name('edit-facility');
		Route::post('edit/{id}', 'FacilityController@update');
		Route::post('destroy_facility', 'FacilityController@destroy')->name('destroy_facility');
		Route::get('{id}/view_case_managers', 'FacilityController@viewCaseManagers')->name('view_case_managers');
		Route::get('{id}/view_clients', 'FacilityController@viewClients')->name('view_clients');
	});

	Route::group(['prefix'=>'case-managers'], function(){
		Route::get('/', 'CaseManagerController@index')->name('case-managers');
		Route::post('/', 'CaseManagerController@store')->name('add-case-manager');
		Route::get('edit-case_mg/{id}', 'CaseManagerController@edit')->name('edit-case_mg');
		Route::post('edit-case_mg/{id}', 'CaseManagerController@update');
		Route::post('destroy_manager','CaseManagerController@destroy')->name('destroy_manager');
		Route::get('{id}/view_clients', 'CaseManagerController@viewClients')->name('view_clients_cm');
	});

	Route::group(['prefix'=>'clients'], function(){
		Route::get('/', 'ClientController@index')->name('clients');
		Route::post('/', 'ClientController@store')->name('add-client');
		Route::get('edit-client/{id}', 'ClientController@edit')->name('edit-client');
		Route::post('edit-client/{id}', 'ClientController@update');
		Route::get('find_case_managers', 'ClientController@findCaseManager')->name('find_case_managers');
		Route::post('destroy_client','ClientController@destroy')->name('destroy_client');
	});
});
