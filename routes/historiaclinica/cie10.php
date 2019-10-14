<?php

Route::group(['prefix' => 'cie10'], function () {

	Route::group(['middleware' => 'auth:api'], function() {

		Route::get('all', 'Historia\Cie10Controller@all');
		Route::post('create/{citapaciente}', 'Historia\Cie10Controller@store');

	});
});