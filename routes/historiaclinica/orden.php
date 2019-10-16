<?php

Route::group(['prefix' => 'orden'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
    Route::get('all', 'Historia\OrdenController@all');
    Route::post('citapaciente/{citapaciente}/create', 'Historia\OrdenController@store');
    Route::post('getOrder/{citapaciente}', 'Historia\OrdenController@getOrderById');
    Route::get('getOrderedCodesumi/{citapaciente}', 'Historia\OrdenController@getOrderedCodesumi');
    Route::get('getOrderedCie/{citapaciente}', 'Historia\OrdenController@getOrderedCie');
    Route::put('edit/{orden}', 'Historia\OrdenController@update');
    Route::post('medicamentos', 'Historia\OrdenController@ordenesMedicamento');
    Route::post('lotes', 'Historia\OrdenController@lotesMedicamentos');
    Route::get('getInCupOrden/{orden}', 'Historia\OrdenController@getOrdeninCupOrden');
    Route::get('getInDetaArticuloOrden/{orden}', 'Historia\OrdenController@getOrdeninDetaArticuloOrden');
    Route::post('getOrderedCup/{citapaciente}', 'Historia\OrdenController@getOrderedCups');
	});
});