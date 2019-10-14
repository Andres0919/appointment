<?php

Route::group(['prefix' => 'pdf'], function () {
    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('print-pdf',  'PDF\PDFController@print');
        
    });
});