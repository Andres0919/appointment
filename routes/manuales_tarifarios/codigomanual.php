<?php

Route::group(['prefix' => 'codigomanual'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
		Route::post('create',   'Tarifarios\CodigomanualController@store');
		Route::post('import',   'Tarifarios\CodigomanualController@import');
        Route::get('all',         'Tarifarios\CodigomanualController@all');                   
        Route::put('edit/{codigomanual}', 'Tarifarios\CodigomanualController@update');
	});
});