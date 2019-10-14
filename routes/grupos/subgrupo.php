<?php

Route::group(['prefix' => 'subgrupo'], function () {
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('all',         'Grupos\SubgrupoController@all');
        Route::get('enabled',         'Grupos\SubgrupoController@enabled');
        Route::post('create',   'Grupos\SubgrupoController@store');                  
        Route::put('edit/{subgrupo}', 'Grupos\SubgrupoController@update');
        Route::put('available/{subgrupo}', 'Grupos\SubgrupoController@available');
    });
});