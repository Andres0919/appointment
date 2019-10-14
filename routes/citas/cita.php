<?php

Route::group(['prefix' => 'cita'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
		Route::post('create',   'Citas\CitaController@store');
        Route::get('all',         'Citas\CitaController@all');                   
        Route::get('enabled',      'Citas\CitaController@enabled');                   
        Route::post('citaspendientes', 'Citas\CitaController@citaspendientesPaciente');
        Route::put('asignarcita/{cita}',      'Citas\CitaController@asignarcita');                   
        Route::put('edit/{cita}', 'Citas\CitaController@update');
        Route::put('cancelar/{cita}', 'Citas\CitaController@cancelar');
        Route::put('bloquear/{cita}', 'Citas\CitaController@bloquearCita');
        Route::put('confirmar/{cita}', 'Citas\CitaController@confirmar');
        Route::get('show/{cita}',   'Citas\CitaController@show');
        Route::get('cronogramahoy',   'Citas\CitaController@cronogramaHoyMedico');
        Route::put('available/{cita}', 'Citas\CitaController@available');

        //Inicio de Historia clinica en la atención del paciente
        Route::post('{citapaciente}/atender', 'Citas\CitaController@atender');
        Route::post('{citapaciente}/motivo', 'Citas\CitaController@motivo');
        Route::get('{citapaciente}/motivo', 'Citas\CitaController@anamnesis');
        Route::post('{citapaciente}/revisionsistema', 'Citas\CitaController@revisionsistema');
        Route::get('{citapaciente}/datospaciente', 'Citas\CitaController@datospaciente');
        Route::put('{paciente}/editarpaciente/{citapaciente}', 'Citas\CitaController@editarpaciente');
	});
});