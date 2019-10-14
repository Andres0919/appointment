<?php

Route::group(['prefix' => 'movimiento'], function () {
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',         'Transaciones\MovimientoController@all');                   
        Route::get('articulos/{movimiento}',  'Transaciones\MovimientoController@articulos');                   
        Route::post('{bodega}/create',   'Transaciones\MovimientoController@store');
        Route::put('edit/{movimiento}',   'Transaciones\MovimientoController@update');
        Route::put('{movimiento}/available', 'Transaciones\MovimientoController@available');
        Route::put('{movimiento}/cancelar', 'Transaciones\MovimientoController@cancelar');

        //Notas
        Route::post('{movimiento}/all/notas',   'Bodegas\NotasController@all');                   
        Route::post('{movimiento}/create/notas',   'Bodegas\NotasController@store');
        Route::put('edit/{notastransacion}',   'Bodegas\NotasController@update');

        Route::post('/dispensar', 'Transaciones\MovimientoController@dispensar');

    });
});
