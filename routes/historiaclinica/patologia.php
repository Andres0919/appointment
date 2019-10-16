<?php

Route::group(['prefix' => 'patologia'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all', 'Historia\PatologiaController@all');
        Route::post('create', 'Historia\PatologiaController@store');
	});
});