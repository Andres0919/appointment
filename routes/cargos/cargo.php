<?php

Route::group(['prefix' => 'cargo'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all',         'Agendas\CargoController@all');
		Route::post('create',   'Agendas\CargoController@store');
        Route::put('edit/{cargo}', 'Agendas\CargoController@update');

        Route::get('{cargo}/actividadcargo/all',   'Agendas\ActividadcargoController@all');                   
        Route::post('{cargo}/actividadcargo/create',   'Agendas\ActividadcargoController@store');                  
        Route::put('{cargo}/actividadcargo/edit/{actividadcargo}', 'Agendas\ActividadcargoController@update');
	});
});