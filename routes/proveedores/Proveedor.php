<?php

Route::group(['prefix' => 'proveedor'], function () {
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',         'Proveedores\ProveedoreController@all');                   
        Route::post('create',   'Proveedores\ProveedoreController@store');                  
        Route::put('edit/{grupo}', 'Proveedores\ProveedoreController@update');
        Route::put('available/{grupo}', 'Proveedores\ProveedoreController@available');
    });
});