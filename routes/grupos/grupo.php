<?php

Route::group(['prefix' => 'grupo'], function () {
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',         'Grupos\GrupoController@all');                   
        Route::post('create',   'Grupos\GrupoController@store');                  
        Route::put('edit/{grupo}', 'Grupos\GrupoController@update');
        Route::put('available/{grupo}', 'Grupos\GrupoController@available');
    });
});