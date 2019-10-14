<?php

Route::group(['prefix' => 'codepropio'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
        Route::post('all',         'Tarifarios\CodepropioController@all');                   
		Route::post('create',   'Tarifarios\CodepropioController@store');
        Route::put('edit/{codepropio}', 'Tarifarios\CodepropioController@update');                   
        Route::get('enabled', 'Tarifarios\CodepropioController@enabled');  
	});
});