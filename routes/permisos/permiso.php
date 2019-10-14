<?php

Route::group(['prefix' => 'permiso'], function () {
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('create',   'Permisos\PermisoController@store');
        Route::get('all',         'Permisos\PermisoController@all');                   
        Route::put('edit/{permission}', 'Permisos\PermisoController@update');
        Route::get('show/{permission}',   'Permisos\PermisoController@show');
    });
});