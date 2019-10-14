<?php

Route::group(['prefix' => 'tipofamilia'], function () {
	Route::group(['middleware' => 'auth:api'], function() {

        Route::get('all',  'Tarifarios\TipofamiliaController@all');
		Route::post('create',   'Tarifarios\TipofamiliaController@store');                    
        Route::put('edit/{tipofamilia}', 'Tarifarios\TipofamiliaController@update');  

	});
});