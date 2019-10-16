<?php

Route::group(['prefix' => 'reps'], function () {
    
    Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all',         'Reps\RepController@all');                   
    });
});