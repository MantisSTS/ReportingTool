<?php

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


Auth::routes();


Route::get('/logout')->name('logout');

// All routes from here must be authenticated and have user-level access or above
Route::group(['middleware' => ['auth', 'level:1']], function() {

	// General routing
    Route::get('/', 'DashboardController@index')->name('dashboard.index');

	Route::get('/home', function() {
		return redirect()->to('/');
	});

	// Manage Reports
	// @TODO: Need to be consistent 
	Route::get('/report/get_jobs_for_client', 'ReportController@getJobsForClient')->name('report.get_jobs_for_client');
	Route::get('/report/get_phases_for_job', 'ReportController@getPhasesForJob')->name('report.get_phases_for_job');
	Route::post('/report/init', 'ReportController@initReportCreate')->name('report.init');
	Route::post('/report/add_phase_to_job', 'ReportController@addPhaseToJob')->name('report.add_phase_to_job');
	Route::post('/report/add_job_to_client', 'ReportController@addJobToClient')->name('report.add_job_to_client');
	
	Route::get('/report/{id}/phases/', 'ReportController@showPhaseForm')->name('report.create_phases');

	Route::post('/report/add-to-report', 'ReportController@addVulnsToReport')->name('report.add_vulnerability_to_report');
	Route::resources(['report' => 'ReportController']);
	Route::get('/report/edit/{id}', 'ReportController@edit')->name('report.edit');
	Route::get('/report/generate/{id}', 'ReportController@generate')->name('report.generate');

	// Manage Clients
	Route::resources(['client' => 'ClientController']);

	// Managing VulnDB
	Route::resources([
	    'vulnerability' => 'VulnerabilityController',
	]);
});
