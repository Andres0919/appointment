<?php

Route::group(['prefix' => 'pacienteantecedente'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
    Route::get('all', 'Historia\PacienteanteceController@all');
    Route::post('create/{citapaciente}', 'Historia\PacienteanteceController@store');
    Route::get('antecedentes/{citapaciente}', 'Historia\PacienteanteceController@antecedentes');
	});
});