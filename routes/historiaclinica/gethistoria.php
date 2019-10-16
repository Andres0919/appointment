<?php

Route::group(['prefix' => 'historiapaciente', 'throttle:60,1'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
    Route::post('gethistoria', 'Historia\ResumenhistoriaController@gethistoria');
	});
});