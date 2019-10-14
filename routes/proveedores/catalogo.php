<?php

Route::group(['prefix' => 'catalogo'], function () {
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',         'Proveedores\CatalogoController@all');                   
        Route::post('create',   'Proveedores\CatalogoController@store');                  
        Route::put('edit/{catalogo}', 'Proveedores\CatalogoController@update');
        Route::put('available/{catalogo}', 'Proveedores\CatalogoController@available');
    });
});