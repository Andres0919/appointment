<?php

Route::group(['prefix' => 'bodega'], function () {
    
    Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all',         'Bodegas\BodegaController@all');     //nuevo cambio              
        Route::post('create',   'Bodegas\BodegaController@store');                  
        Route::put('edit/{bodega}', 'Bodegas\BodegaController@update');
        Route::put('available/{bodega}', 'Bodegas\BodegaController@available');

        Route::post('{bodega}/articulo/all',   'Bodegas\BodegarticuloController@all');
        Route::post('inventariobodega',   'Bodegas\BodegarticuloController@inventariobodega');
        Route::post('{bodega}/articulo/allArticulos',   'Bodegas\BodegarticuloController@allArticulos');
        Route::post('{bodega}/articulo/create',   'Bodegas\BodegarticuloController@store');
        Route::put('{bodega}/articulo/edit/{detallearticulo}', 'Bodegas\BodegarticuloController@update');
        Route::put('{bodega}/articulo/available/{detallearticulo}',    'Bodegas\BodegarticuloController@available');

        Route::post('{bodega}/ordencompra/allOrdens',   'Bodegas\OrdencompraController@allOrdens');
        Route::post('{bodega}/ordencompra/allacepted',   'Bodegas\OrdencompraController@allacepted');
        Route::post('{bodega}/ordencompra/create',   'Bodegas\OrdencompraController@store');
        Route::put('{bodega}/ordencompra/acceptRequest',   'Bodegas\OrdencompraController@acceptRequest');
    });
});