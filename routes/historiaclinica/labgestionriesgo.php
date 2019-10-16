<?php

Route::group(['prefix' => 'labgestion'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
    Route::get('{citapaciente}/all', 'Historia\LabgestionriesgosController@all');
    Route::post('{citapaciente}/create', 'Historia\LabgestionriesgosController@store');
    Route::get('{citapaciente}/getLabgestion', 'Historia\LabgestionriesgosController@getLabgestion');
	});
});