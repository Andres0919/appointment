<?php

Route::group(['prefix' => 'parentescoantecedente'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
    Route::get('all', 'Historia\ParentescoantecedeController@all');
    Route::post('create/{citapaciente}', 'Historia\ParentescoantecedeController@store');
	});
});