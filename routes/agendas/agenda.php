<?php

Route::group(['prefix' => 'agenda'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
		Route::post('create',   'Agendas\AgendaController@store');
        Route::get('all',         'Agendas\AgendaController@all');
        Route::get('agendaDisponible',  'Agendas\AgendaController@agendaDisponible');
        Route::get('enabled',        'Agendas\AgendaController@enabled');
        Route::put('edit/{agenda}', 'Agendas\AgendaController@update');
        Route::put('cancelar/{agenda}', 'Agendas\AgendaController@cancelarAgenda');
        Route::put('bloquear/{agenda}', 'Agendas\AgendaController@bloquearAgenda');
        Route::get('show/{agenda}',   'Agendas\AgendaController@show');
        Route::post('agendaDisponible', 'Agendas\AgendaController@agendaDisponible');
        Route::post('agendamedicos', 'Agendas\AgendaController@agendamedicos');
        Route::put('inhabilitaragenda/{agenda}', 'Agendas\AgendaController@inhabilitarAgenda');
	});
});