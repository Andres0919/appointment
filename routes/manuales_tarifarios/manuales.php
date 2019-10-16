<?php

Route::group(['prefix' => 'manuales'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all',  'Tarifarios\ManualesController@all');
		Route::post('create',   'Tarifarios\ManualesController@store');                   
	});
});