<?php

Route::group(['prefix' => 'movimiento', 'throttle:60,1'], function () {
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',         'Transaciones\MovimientoController@all');                   
        Route::get('articulos/{movimiento}',  'Transaciones\MovimientoController@articulos');                   
        Route::post('{bodega}/create',   'Transaciones\MovimientoController@store');
        Route::post('{bodega}/entradafactura',   'Transaciones\MovimientoController@entradaFactura');
        Route::put('edit/{movimiento}',   'Transaciones\MovimientoController@update');
        Route::put('{movimiento}/available', 'Transaciones\MovimientoController@available');
        Route::post('{movimiento}/entrace', 'Transaciones\MovimientoController@entrace');
        Route::put('{movimiento}/cancelar', 'Transaciones\MovimientoController@cancelar');

        //Notas
        Route::post('{movimiento}/all/notas',   'Bodegas\NotasController@all');                   
        Route::post('{movimiento}/create/notas',   'Bodegas\NotasController@store');
        Route::put('edit/{notastransacion}',   'Bodegas\NotasController@update');

        Route::post('/dispensar', 'Transaciones\MovimientoController@dispensar');
        Route::post('/massinvoices', 'Transaciones\MovimientoController@massInvoices');

    });
});
