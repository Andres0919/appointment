<?php

Route::group(['prefix' => 'bodega'], function () {
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',         'Bodegas\BodegaController@all');     //nuevo cambio              
        Route::post('create',   'Bodegas\BodegaController@store');                  
        Route::put('edit/{bodega}', 'Bodegas\BodegaController@update');
        Route::put('available/{bodega}', 'Bodegas\BodegaController@available');

        Route::post('{bodega}/articulo/all',   'Bodegas\BodegarticuloController@all');                   
        Route::post('{bodega}/articulo/create',   'Bodegas\BodegarticuloController@store');                  
        Route::put('{bodega}/articulo/edit/{detallearticulo}', 'Bodegas\BodegarticuloController@update');
        Route::put('{bodega}/articulo/available/{detallearticulo}',    'Bodegas\BodegarticuloController@available');
    });
});