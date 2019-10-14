<?php

Route::group(['prefix' => 'tipomanuales'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',         'Tarifarios\TipomanualController@all');                   
		Route::post('create',   'Tarifarios\TipomanualController@store');
		Route::post('import',   'Tarifarios\TipomanualController@import');
        Route::put('edit/{tipomanuale}', 'Tarifarios\TipomanualController@update');
        Route::put('available/{tipomanuale}', 'Tarifarios\TipomanualController@available');   
	});
});