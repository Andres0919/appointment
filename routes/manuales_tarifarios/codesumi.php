<?php

Route::group(['prefix' => 'codesumi'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
		Route::post('create',   'Tarifarios\CodesumiController@store');
        Route::get('all',         'Tarifarios\CodesumiController@all');
        Route::put('edit/{codesumi}', 'Tarifarios\CodesumiController@update');
        Route::get('show/{codesumi}',   'Tarifarios\CodesumiController@show');
        Route::put('available/{codesumi}', 'Tarifarios\CodesumiController@available');
        Route::get('enabled', 'Tarifarios\CodesumiController@enabled');
        Route::get('medicamentosumi/{citapaciente}', 'Tarifarios\CodesumiController@medicamentos');
	});
});