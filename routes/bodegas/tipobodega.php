<?php

Route::group(['prefix' => 'tipobodega'], function () {
    
    Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all',         'Bodegas\TipobodegaController@all');                   
        Route::post('create',   'Bodegas\TipobodegaController@store');                  
        Route::put('edit/{tipobodega}', 'Bodegas\TipobodegaController@update');
        Route::put('available/{tipobodega}', 'Bodegas\TipobodegaController@available');
    });
});