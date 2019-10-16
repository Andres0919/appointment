<?php

Route::group(['prefix' => 'file'], function () {
    Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::post('setFiles/{citapaciente}', 'Files\FileController@setFiles');
        Route::get('getFiles/{citapaciente}', 'Files\FileController@getFiles');
    });
});