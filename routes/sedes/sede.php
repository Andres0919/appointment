<?php

Route::group(['prefix' => 'sede'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
		Route::post('create',   'Sedes\SedeController@store');
        Route::get('all',         'Sedes\SedeController@all');                   
        Route::get('enabled',         'Sedes\SedeController@enabled');                   
        Route::put('edit/{sede}', 'Sedes\SedeController@update');
        Route::get('show/{sede}',   'Sedes\SedeController@show');
        Route::put('available/{sede}', 'Sedes\SedeController@available');

        Route::post('{sede}/consultorio/create',   'Consultorios\ConsultorioController@store');
		Route::get('{sede}/consultorio/all',   'Consultorios\ConsultorioController@all');
		Route::put('{sede}/consultorio/edit/{consultorio}',   'Consultorios\ConsultorioController@update');
		Route::get('{sede}/consultorio/show/{consultorio}',   'Consultorios\ConsultorioController@show');
		Route::put('{sede}/consultorio/available/{consultorio}',   'Consultorios\ConsultorioController@available');
	});
});