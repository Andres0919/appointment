<?php

Route::group(['prefix' => 'tiposervicio'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
		Route::post('create',   'Tarifarios\TiposervicioController@store');
        Route::get('all',         'Tarifarios\TiposervicioController@all');
        Route::put('edit/{tiposervicio}', 'Tarifarios\TiposervicioController@update');
        Route::get('show/{tiposervicio}',   'Tarifarios\TiposervicioController@show');
        Route::put('available/{tiposervicio}', 'Tarifarios\TiposervicioController@available');                   
        Route::get('enabled', 'Tarifarios\TiposervicioController@enabled');
	});
});