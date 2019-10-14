<?php

Route::group(['prefix' => 'parentescoantecedente'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
    Route::get('all', 'Historia\ParentescoantecedeController@all');
    Route::post('create/{citapaciente}', 'Historia\ParentescoantecedeController@store');
	});
});