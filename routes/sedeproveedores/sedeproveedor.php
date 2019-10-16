<?php

Route::group(['prefix' => 'sedeproveedore'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        
        Route::post('all',   'Sedeprestadores\SedeproveedorController@all');
        Route::get('allproveedores', 'Sedeprestadores\SedeproveedorController@allproveedores');     
        Route::post('create',   'Sedeprestadores\SedeproveedorController@store');
        Route::put('edit/{sedeproveedore}', 'Sedeprestadores\SedeproveedorController@update');
        Route::put('disable/{sedeproveedore}', 'Sedeprestadores\SedeproveedorController@disable');

        Route::post('Serviciosede/create',   'Sedeprestadores\SedeproveedorController@storeServiciosede');
	});
});