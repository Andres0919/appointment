<?php

Route::group(['prefix' => 'tipoOrden'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
    Route::get('all', 'Historia\TipordenController@all');
    Route::post('citapaciente/{citapaciente}/create', 'Historia\TipordenController@store');
    Route::put('edit/{tipoOrden}', 'Historia\TipordenController@update');
	});
});