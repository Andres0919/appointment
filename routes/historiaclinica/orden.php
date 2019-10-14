<?php

Route::group(['prefix' => 'orden'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
    Route::get('all', 'Historia\OrdenController@all');
    Route::post('citapaciente/{citapaciente}/create', 'Historia\OrdenController@store');
    Route::put('edit/{orden}', 'Historia\OrdenController@update');
    Route::post('medicamentos', 'Historia\OrdenController@ordenesMedicamento');
    Route::post('lotes', 'Historia\OrdenController@lotesMedicamentos');
	});
});