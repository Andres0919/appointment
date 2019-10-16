<?php

Route::group(['prefix' => 'estado'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
		Route::post('create',   'Estados\EstadoController@store');
        Route::get('all',         'Estados\EstadoController@all');                   
        Route::put('edit/{estado}', 'Estados\EstadoController@update');
        Route::get('show/{estado}',   'Estados\EstadoController@show');
        Route::put('available/{estado}', 'Estados\EstadoController@available');
	});
});