<?php

Route::group(['prefix' => 'tipoagenda'], function () {
    
    Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::post('create',   'Agendas\TipoagendaController@store');
        Route::get('all',         'Agendas\TipoagendaController@all');                   
        Route::get('enabled',  'Agendas\TipoagendaController@enabled');                   
        Route::put('edit/{tipoAgenda}', 'Agendas\TipoagendaController@update');
        Route::get('show/{tipoAgenda}',   'Agendas\TipoagendaController@show');
        Route::get('habilitados', 'Agendas\TipoagendaController@habilitados');
        Route::put('available/{tipoAgenda}', 'Agendas\TipoagendaController@available');
    });
});