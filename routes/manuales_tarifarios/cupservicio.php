<?php

Route::group(['prefix' => 'cupservicio'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::post('create',  'Tarifarios\CupservicioController@store');              
		Route::get('all',  'Tarifarios\CupservicioController@all');
		Route::put('edit/{cupservicio}',  'Tarifarios\CupservicioController@update');
	});
});