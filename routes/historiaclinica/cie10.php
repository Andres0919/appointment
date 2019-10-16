<?php

Route::group(['prefix' => 'cie10'], function () {
    Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function () {
        Route::get('all', 'Historia\Cie10Controller@all');
        Route::post('create/{citapaciente}', 'Historia\Cie10Controller@store');
        Route::get('diagnostico/{citapaciente}', 'Historia\Cie10Controller@getDiagnostico');
        Route::get('deleteDiagnostic/{cie10paciente}', 'Historia\Cie10Controller@deleteDiagnostico');
        Route::post('setDiagnostic/{citapaciente}', 'Historia\Cie10Controller@setDiagnostic');
    });
});
