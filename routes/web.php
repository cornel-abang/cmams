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
	// dd(Hash::make("godsplan22"));
    return view('q-login');
})->name('home');

Route::get('login', function(){
	return view('q-login');
});

Route::get('attendance', function(){
	return view('attendance.tracker');
});
Route::get('facility/coordinates', function(){
	return view('attendance.coordinates');
});

Route::get('managers','CaseManagerController@getManagers')->name('get_managers');

Route::post('check_attendance', 'CaseManagerController@attendance')->name('check_attendance');
Route::post('facility/coordinates', 'FacilityController@saveCoords')->name('save.coords');

Route::post('login', 'UserController@login')->name('login');

// Dhis Access Routes
Route::get('dhis', 'DhisController@index')->name('dhis');
Route::post('dhis', 'DhisController@save');
Route::post('import-dhis', 'DhisController@importData')->name('indicators');
// Route::get('dhis-login', 'DhisController@login');

// Route::group(['middleware'=>'auth:web'], function(){
	Route::group(['prefix'=>'fhi360'], function(){
		Route::get('dashboard', 'DashboardController@index')->name('dashboard');
		Route::get('chart_data','DashboardController@getChartData')->name('chart_data');
		Route::get('leaderboard', 'DashboardController@leaderboard')->name('leaderboard');
		Route::get('get_btm_4', 'DashboardController@bottomFour')->name('get_btm_4');
		Route::get('logout', 'UserController@logout')->name('logout');
	});
	Route::group(['prefix'=>'facilities'], function(){
		Route::get('/', 'FacilityController@index')->name('facilities');
		Route::post('/', 'FacilityController@store')->name('add-facility');
		Route::get('edit/{id}', 'FacilityController@edit')->name('edit-facility');
		Route::post('edit/{id}', 'FacilityController@update');
		Route::get('destroy_facility/{id}', 'FacilityController@destroy')->name('destroy_facility');
		Route::get('{id}/view_case_managers', 'FacilityController@viewCaseManagers')->name('view_case_managers');
		Route::get('{id}/view_clients', 'FacilityController@viewClients')->name('view_clients');
		Route::get('{id}/view_facility', 'FacilityController@show')->name('view_facility');
	});

	Route::group(['prefix'=>'case-managers'], function(){
		Route::get('/', 'CaseManagerController@index')->name('case-managers');
		Route::post('/', 'CaseManagerController@store')->name('add-case-manager');
		Route::get('edit-case_mg/{id}', 'CaseManagerController@edit')->name('edit-case_mg');
		Route::post('edit-case_mg/{id}', 'CaseManagerController@update');
		Route::get('destroy_manager/{id}','CaseManagerController@destroy')->name('destroy_manager');
		Route::get('{id}/view_clients', 'CaseManagerController@viewClients')->name('view_clients_cm');
		Route::any('search_client', 'CaseManagerController@search')->name('search_client');
		Route::post('cm_uploads', 'CaseManagerController@managersUpload')->name('cm-upload');

		//Attendance
		Route::get('attendance', 'CaseManagerController@allAttendance')->name('atts');
		Route::get('permitted_list', 'CaseManagerController@permittedList')->name('permitted');
		Route::get('timesheets','CaseManagerController@timesheets')->name('timesheets');
		Route::get('timesheet/{id}','CaseManagerController@timesheet')->name('timesheet');
	});

	Route::group(['prefix'=>'clients'], function(){
		Route::get('/', 'ClientController@index')->name('clients');
		Route::post('/', 'ClientController@store')->name('add-client');
		Route::get('edit-client/{id}', 'ClientController@edit')->name('edit-client');
		Route::post('edit-client/{id}', 'ClientController@update');
		Route::get('find_case_managers', 'ClientController@findCaseManager')->name('find_case_managers');
		Route::post('destroy_client','ClientController@destroy')->name('destroy_client');
		Route::post('assign-client','ClientController@assignToCm')->name('assign-client');
	});

	Route::group(['prefix'=>'reports'], function(){
		Route::get('/', 'ReportController@index')->name('daily');
		Route::post('/', 'ReportController@store')->name('store');
		Route::get('get_case_manager', 'ReportController@getCaseManager')->name('get_case_manager');
		Route::get('edit/{id}', 'ReportController@edit')->name('edit_report');
		Route::post('edit/{id}', 'ReportController@update');
		Route::post('destroy_report', 'ReportController@destroy')->name('destroy_report');
		Route::any('by_date', 'ReportController@getReportByDate')->name('reports_by_date');
		Route::any('by_week', 'ReportController@getReportByWeek')->name('reports_by_week');
		Route::any('by_month', 'ReportController@getReportByMonth')->name('reports_by_month');
		Route::any('by_year', 'ReportController@getReportByYear')->name('reports_by_year');
	});

	Route::group(['prefix'=>'tracking'], function(){
		Route::get('add', 'TrackingController@create')->name('add');
		Route::any('find_client_for_tracking', 'TrackingController@searchClient')->name('find_client_for_tracking');
		Route::any('store_tracking_report', 'TrackingController@store')->name('store_tracking_report');
		Route::get('/', 'TrackingController@index')->name('tracking_reports');
		Route::get('{id}/edit', 'TrackingController@edit')->name('edit-tracking');
		Route::post('{id}/edit', 'TrackingController@update');
		Route::post('destroy_tracking', 'TrackingController@destroy')->name('destroy_tracking');
	});

	Route::group(['prefix'=>'appointments'], function(){
		Route::get('add', 'AppointmentController@create')->name('add-appts');
		Route::post('add', 'AppointmentController@store');
		Route::get('/', 'AppointmentController@index')->name('appointments');
		Route::get('verify_appt/{cm_id}', 'AppointmentController@verifyAppt')->name('verify_appt');
		Route::get('vlc', 'AppointmentController@vlc')->name('vlc');
		Route::get('before_due', 'AppointmentController@beforeDue')->name('before');
		Route::get('before_future', 'AppointmentController@beforeDueFuture')->name('before_future');
		Route::get('met', 'AppointmentController@metAppts')->name('met');
		Route::get('missed', 'AppointmentController@missedAppts')->name('missed');
		// EXPORTS
		Route::get('export-past', 'AppointmentController@exportBeforeDuePast')->name('export-past');
		Route::get('export-future', 'AppointmentController@exportBeforeDueFuture')->name('export-future');
		Route::get('export-met', 'AppointmentController@exportMetAppts')->name('export-met');
		Route::get('export-missed', 'AppointmentController@exportMissedAppts')->name('export-missed');
	});

	Route::group(['prefix' => 'radet_file'], function(){
		Route::get('upload_radet', 'RadetController@uploadRadet')->name('upload.radet');
		Route::post('radet/import', 'RadetController@importRadetFile')->name('import.radet');
	});

	Route::group(['prefix' => 'tat'], function(){
		Route::get('records', 'TATController@index')->name('tat.show');
		Route::get('save_tat', 'TATController@saveRecord')->name('save_tat');

		Route::post('add-tat', 'TATController@import')->name('tat');
		Route::post('single_tat', 'TATController@addTAT')->name('tat.single');
		Route::post('add-patients', 'TATController@importPatients')->name('patients');
		Route::get('compare-results', 'TATController@showImport')->name('tat.compare');
		Route::post('compare-results', 'TATController@uploadCopies');
	});

	//Add vLC Results
	// Route::get('results', 'RadetController@saveVlcRes');

	//some test route
	Route::get('performance/eval', 'RadetController@evalPerformance');

	//coords
	Route::post('coords', 'FacilityController@uploadCoords')->name('coords');

	//Managers update
	Route::post('update-managers', 'CaseManagerController@managersUpload')->name('u-managers');

	//Analyse 
	Route::get('analyse', 'RadetController@evalPerformance')->name('analyse');
// });
