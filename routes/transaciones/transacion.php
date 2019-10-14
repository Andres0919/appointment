<?php

Route::group(['prefix' => 'transacion'], function () {
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',         'Transaciones\TransacionController@all');                   
        Route::post('create',   'Transaciones\TransacionController@store');                  
        Route::put('edit/{transacion}', 'Transaciones\TransacionController@update');
        Route::put('available/{transacion}', 'Transaciones\TransacionController@available');
    });
});