<?php

Route::group(['prefix' => 'reps'], function () {
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',         'Reps\RepController@all');                   
    });
});