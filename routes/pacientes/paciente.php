<?php

Route::group(['prefix' => 'paciente'], function () {
    Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function () {
        Route::post('create', 'Pacientes\PacienteController@store');
        Route::get('all', 'Pacientes\PacienteController@all');
        // Route::post('import',         'Pacientes\PacienteController@import');
        Route::put('edit/{paciente}', 'Pacientes\PacienteController@update');
        Route::put('edit_ubicacion_data/{paciente}', 'Pacientes\PacienteController@updateUbicacionData');
        Route::put('update_email/{paciente}', 'Pacientes\PacienteController@updateEmail');
        Route::get('show/{paciente}', 'Pacientes\PacienteController@show');
        Route::get('getPaciente/{cedula}', 'Pacientes\PacienteController@getPaciente');
        Route::get('showEnabled/{cedula}', 'Pacientes\PacienteController@showEnabled');
        Route::get('citaPendiente/{paciente}', 'Pacientes\PacienteController@citaPendiente');
        Route::get('getPacienteWithCita/{citapaciente}', 'Pacientes\PacienteController@getPacienteWithCita');
    });
});
