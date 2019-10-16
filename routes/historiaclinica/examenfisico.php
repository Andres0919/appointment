<?php

Route::group(['prefix' => 'examenfisico'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
    Route::get('{citapaciente}/all', 'Historia\ExamenfisicosController@all');
    Route::post('antropometricas/{citapaciente}', 'Historia\ExamenfisicosController@antropometricas');
    Route::post('signosvitales/{citapaciente}', 'Historia\ExamenfisicosController@signosvitales');
    Route::post('{citapaciente}/examenfisico/', 'Historia\ExamenfisicosController@examenfisico');
    Route::get('{citapaciente}/examenfisico', 'Historia\ExamenfisicosController@getExamenFisico');
	});
});