<?php

Route::group(['prefix' => 'especialidad'], function () {
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('create',   'Especialidades\EspecialidadeController@store');
        Route::get('all',         'Especialidades\EspecialidadeController@all');                   
        Route::put('edit/{especialidade}', 'Especialidades\EspecialidadeController@update');
        Route::put('available/{especialidade}', 'Especialidades\EspecialidadeController@available');
        Route::get('{user}/especialidadMedicos', 'Especialidades\EspecialidadeController@especialidadMedico');        
        Route::get('tipoactividad/{especialidade}',   'Especialidades\EspecialidadeController@especialidadActividad');

        Route::post('{especialidade}/Especialidadtipoagenda/create',   'Especialidadtipoagendas\EspecialidadtipoagendaController@store');
        Route::get('Especialidadtipoagenda/all',   'Especialidadtipoagendas\EspecialidadtipoagendaController@all');
    });
});