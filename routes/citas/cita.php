<?php

Route::group(['prefix' => 'cita'], function () {
    Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function () {
        Route::post('create', 'Citas\CitaController@store');
        Route::get('all', 'Citas\CitaController@all');
        Route::get('enabled', 'Citas\CitaController@enabled');
        Route::post('citaspendientes', 'Citas\CitaController@citaspendientesPaciente');
        Route::put('asignarcita/{cita}', 'Citas\CitaController@asignarcita');
        Route::put('edit/{cita}', 'Citas\CitaController@update');
        Route::put('cancelar/{cita}', 'Citas\CitaController@cancelar');
        Route::put('bloquear/{cita}', 'Citas\CitaController@bloquearCita');
        // Route::put('confirmar/{cita}', 'Citas\CitaController@confirmar');
        Route::get('show/{cita}', 'Citas\CitaController@show');
        Route::get('cronogramahoy', 'Citas\CitaController@cronogramaHoyMedico');
        Route::put('available/{cita}', 'Citas\CitaController@available');
        Route::get('notProgramed', 'Citas\CitaController@notProgramed');

        //Inicio de Historia clinica en la atención del paciente
        Route::post('{citapaciente}/atender', 'Citas\CitaController@atender');
        Route::put('inasistio/{cita}', 'Citas\CitaController@inasistio');
        Route::post('{citapaciente}/motivo', 'Citas\CitaController@motivo');
        Route::get('{citapaciente}/motivo', 'Citas\CitaController@anamnesis');
        Route::post('{citapaciente}/revisionsistema', 'Citas\CitaController@revisionsistema');
        Route::get('{citapaciente}/datospaciente', 'Citas\CitaController@datospaciente');
        Route::put('{paciente}/editarpaciente/{citapaciente}', 'Citas\CitaController@editarpaciente');
        Route::post('{citapaciente}/setTime', 'Citas\CitaController@setTime');
        Route::post('{citapaciente}/getTime', 'Citas\CitaController@getTimeIngreso');
        Route::put('update-state-consulta/{citapaciente}', 'Citas\CitaController@update_state_consulta');
        Route::put('update-state-atendida/{citapaciente}', 'Citas\CitaController@update_state_atendida');

        //Paciente
        Route::post('create_cita_paciente/{paciente}', 'Citas\CitaController@create_cita_paciente');
    });
});
