<?php

Route::group(['prefix' => 'autorizacion'], function () {
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',         'Historia\AutorizacionController@listaAutorizaciones');                   
        Route::post('create',   'Historia\TipobodegaController@store');                  
        Route::put('edit/{tipobodega}', 'Historia\TipobodegaController@update');
        Route::put('available/{tipobodega}', 'Historia\TipobodegaController@available');
    });
});