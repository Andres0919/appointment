<?php

Route::group(['prefix' => 'tipo'], function () {
    
    Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all',         'Transaciones\TipoController@all');                   
        Route::post('create',   'Transaciones\TipoController@store');                  
        Route::put('edit/{tipo}', 'Transaciones\TipoController@update');
        Route::put('available/{tipo}', 'Transaciones\TipoController@available');
    });
});