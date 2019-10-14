<?php

Route::group(['prefix' => 'detallearticulo'], function () {
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',         'Articulos\DetallearticuloController@all');
        Route::post('detalleMedicamento', 'Articulos\DetallearticuloController@detalleMedicamento');                   
        Route::post('create',   'Articulos\DetallearticuloController@store');                  
        Route::put('edit/{detallearticulo}', 'Articulos\DetallearticuloController@update');
    });
});