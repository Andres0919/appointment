<?php

Route::group(['prefix' => 'role'], function () {
    
    Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::post('create',   'Roles\RoleController@store');
        Route::get('all',         'Roles\RoleController@all');                   
        Route::put('edit/{role}', 'Roles\RoleController@update');
        Route::get('show/{role}',   'Roles\RoleController@show');
    });
});