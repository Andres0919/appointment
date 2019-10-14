<?php

Route::group(['prefix' => 'diagnosticos'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
    Route::get('{citapaciente}/all', 'Historia\ExamenfisicosController@all');
    Route::post('antropometricas/{citapaciente}', 'Historia\ExamenfisicosController@antropometricas');
    Route::post('signosvitales/{citapaciente}', 'Historia\ExamenfisicosController@signosvitales');
    Route::post('examenfisico/{citapaciente}', 'Historia\ExamenfisicosController@examenfisico');
	});
});