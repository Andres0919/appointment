<?php

Route::group(['prefix' => 'antecedente'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
    Route::get('all', 'Historia\AntecedenteController@all');
    Route::post('create', 'Historia\AntecedenteController@store');
    Route::put('edit/{antecedente}', 'Historia\AntecedenteController@update');

    Route::post('parentescoantecede/{citapaciente}/create', 'Historia\PacienteanteceController@store');
	});
});