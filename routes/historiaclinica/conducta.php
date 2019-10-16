<?php

Route::group(['prefix' => 'conducta'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
    Route::get('{citapaciente}/all', 'Historia\ConductaController@all');
    Route::post('{citapaciente}/final', 'Historia\ConductaController@fin');
    Route::post('getConductaByCita', 'Historia\ConductaController@getConductaByCita');
	});
});