<?php

Route::group(['prefix' => 'tipocodigos'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',  'Tarifarios\TipocodigoController@all');
		Route::post('create',   'Tarifarios\TipocodigoController@store');                   
	});
});