<?php

Route::group(['prefix' => 'estilovida'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
    Route::get('{citapaciente}/all', 'Historia\EstilovidaController@all');
    Route::post('{citapaciente}/create', 'Historia\EstilovidaController@store');
    Route::get('{citapaciente}/lifeStyle', 'Historia\EstilovidaController@getLifeStyle');
	});
});