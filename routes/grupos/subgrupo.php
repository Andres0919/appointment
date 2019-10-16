<?php

Route::group(['prefix' => 'subgrupo'], function () {
    
    Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::post('all',         'Grupos\SubgrupoController@all');
        Route::get('enabled',         'Grupos\SubgrupoController@enabled');
        Route::post('create',   'Grupos\SubgrupoController@store');                  
        Route::put('edit/{subgrupo}', 'Grupos\SubgrupoController@update');
        Route::put('available/{subgrupo}', 'Grupos\SubgrupoController@available');
    });
});