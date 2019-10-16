<?php

Route::group(['prefix' => 'colegio'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
    Route::get('all', 'Historia\ColegioController@all');
    Route::post('create', 'Historia\ColegioController@store');
    Route::post('disable', 'Historia\ColegioController@disable');
    Route::post('getColegioByName', 'Historia\ColegioController@getColegioByName');
	});
});