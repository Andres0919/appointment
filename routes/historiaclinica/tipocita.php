<?php

Route::group(['prefix' => 'tipocita'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all', 'Historia\TipocitaController@all');
        Route::post('create', 'Historia\TipocitaController@store');
	});
});