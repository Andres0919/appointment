<?php

Route::group(['prefix' => 'tipocodigos'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all',  'Tarifarios\TipocodigoController@all');
		Route::post('create',   'Tarifarios\TipocodigoController@store');                   
	});
});