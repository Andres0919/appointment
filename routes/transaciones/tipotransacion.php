<?php

Route::group(['prefix' => 'tipotransacion'], function () {
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',         'Transaciones\TipotransacionController@all');                   
        Route::post('create',   'Transaciones\TipotransacionController@store');                  
        Route::put('edit/{tipotransacion}', 'Transaciones\TipotransacionController@update');
        Route::put('available/{tipotransacion}', 'Transaciones\TipotransacionController@available');
    });
});