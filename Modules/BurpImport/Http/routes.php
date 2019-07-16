<?php

Route::group(['middleware' => 'web', 'prefix' => 'burpimport', 'namespace' => 'Modules\BurpImport\Http\Controllers'], function()
{
	Route::get('/test', 'BurpImportController@index');
});
