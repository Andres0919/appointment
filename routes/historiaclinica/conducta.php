<?php

Route::group(['prefix' => 'conducta'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
    Route::get('{citapaciente}/all', 'Historia\ConductaController@all');
    Route::post('{citapaciente}/final', 'Historia\ConductaController@fin');
	});
});