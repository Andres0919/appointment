<?php

Route::group(['prefix' => 'patologia'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all', 'Historia\PatologiaController@all');
        Route::post('create', 'Historia\PatologiaController@store');
	});
});