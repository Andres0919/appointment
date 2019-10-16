<?php

Route::group(['prefix' => 'consultorio'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
		Route::post('create',   'Consultorios\ConsultorioController@store');
        Route::get('all',         'Consultorios\ConsultorioController@all');                   
        Route::get('enabled',         'Consultorios\ConsultorioController@enabled');                   
        Route::put('edit/{consultorio}', 'Consultorios\ConsultorioController@update');
        Route::get('show/{consultorio}',   'Consultorios\ConsultorioController@show');
        Route::put('available/{consultorio}', 'Consultorios\ConsultorioController@available');
	});
});