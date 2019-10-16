<?php

Route::group(['prefix' => 'proveedor'], function () {
    
    Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all',         'Proveedores\ProveedoreController@all');                   
        Route::post('create',   'Proveedores\ProveedoreController@store');                  
        Route::put('edit/{grupo}', 'Proveedores\ProveedoreController@update');
        Route::put('available/{grupo}', 'Proveedores\ProveedoreController@available');
    });
});