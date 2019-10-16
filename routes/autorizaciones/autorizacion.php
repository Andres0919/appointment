<?php

Route::group(['prefix' => 'autorizacion'], function () {
    Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function () {
        Route::post('allMedicamentos', 'Historia\AutorizacionController@listaAutorizacionesMedicamentos');
        Route::post('allServicios', 'Historia\AutorizacionController@listaAutorizacionesServicios');
        Route::post('listAuthMedicByState', 'Historia\AutorizacionController@listAuthMedicByState');
        Route::post('listAuthServByState', 'Historia\AutorizacionController@listAuthServByState');
        Route::post('StateAprob', 'Historia\AutorizacionController@autorizacionStateAprob');
        Route::post('StateInad', 'Historia\AutorizacionController@autorizacionStateInad');
        Route::post('StateNeg', 'Historia\AutorizacionController@autorizacionStateNeg');
        Route::post('StateAnu', 'Historia\AutorizacionController@autorizacionStateAnu');
        Route::post('UpdateMedic/{detaarticulorden}', 'Historia\AutorizacionController@updateMedicamento');
        Route::post('UpdateServ/{cuporden}', 'Historia\AutorizacionController@updateServicio');
        Route::post('getExcelForMedicamentos', 'Historia\AutorizacionController@getExcelForMedicamentos');
        Route::post('getExcelForServicios', 'Historia\AutorizacionController@getExcelForServicios');
        Route::post('create', 'Historia\TipobodegaController@store');
        Route::put('edit/{tipobodega}', 'Historia\TipobodegaController@update');
        Route::put('available/{tipobodega}', 'Historia\TipobodegaController@available');
    });
});
