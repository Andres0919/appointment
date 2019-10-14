<?php

Route::group(['prefix' => 'estilovida'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
    Route::get('{citapaciente}/all', 'Historia\EstilovidaController@all');
    Route::post('{citapaciente}/create', 'Historia\EstilovidaController@store');
	});
});