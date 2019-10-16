<?php

Route::group(['prefix' => 'tipoprestador'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all',         'Proveedores\TipoprestadorController@all');                   
		Route::post('create',   'Proveedores\TipoprestadorController@store');
        Route::put('edit/{tipoprestador}', 'Proveedores\TipoprestadorController@update');                   
        Route::get('enabled', 'Proveedores\TipoprestadorController@enabled');  
	});
});