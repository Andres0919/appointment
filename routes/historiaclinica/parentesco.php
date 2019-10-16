<?php

Route::group(['prefix' => 'parentesco'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
    Route::get('all', 'Historia\ParentescoController@all');
    Route::post('create', 'Historia\ParentescoController@store');
    Route::put('edit/{parentesco}', 'Historia\ParentescoController@update');
	});
});