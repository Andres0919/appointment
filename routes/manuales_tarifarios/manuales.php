<?php

Route::group(['prefix' => 'manuales'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',  'Tarifarios\ManualesController@all');
		Route::post('create',   'Tarifarios\ManualesController@store');                   
	});
});