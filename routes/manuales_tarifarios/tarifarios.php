<?php

Route::group(['prefix' => 'tarifario'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all',  'Tarifarios\TarifarioController@all');
		Route::post('create',   'Tarifarios\TarifarioController@store');                    
        Route::put('edit/{tarifario}', 'Tarifarios\TarifarioController@update');                  
	});
});