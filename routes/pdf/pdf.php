<?php

Route::group(['prefix' => 'pdf'], function () {
    Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::post('print-pdf',  'PDF\PDFController@print');
        
    });
});