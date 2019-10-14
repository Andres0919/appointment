<?php

Route::group(['prefix' => 'examenfisico'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
    Route::get('{citapaciente}/all', 'Historia\ExamenfisicosController@all');
    Route::post('antropometricas/{citapaciente}', 'Historia\ExamenfisicosController@antropometricas');
    Route::post('signosvitales/{citapaciente}', 'Historia\ExamenfisicosController@signosvitales');
    Route::post('{citapaciente}/examenfisico/', 'Historia\ExamenfisicosController@examenfisico');
	});
});