<?php

Route::group(['prefix' => 'municipio'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
    Route::get('all', 'Municipios\MunicipioController@all');
	});
});