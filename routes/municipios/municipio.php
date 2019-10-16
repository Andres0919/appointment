<?php

Route::group(['prefix' => 'municipio'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
    Route::get('all', 'Municipios\MunicipioController@all');
	});
});