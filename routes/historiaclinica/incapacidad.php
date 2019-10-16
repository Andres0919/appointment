<?php

Route::group(['prefix' => 'incapacidad'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all', 'Historia\IncapacidadesController@all');
        Route::post('create', 'Historia\IncapacidadesController@store');
        Route::post('getIncByCedula', 'Historia\IncapacidadesController@getIncapacidadByCedula');
        Route::post('changeInc', 'Historia\IncapacidadesController@changeIncapacidadToAnulado');
        Route::get('AllExcel', 'Historia\IncapacidadesController@getIncapacidadesByActive');
	});
});