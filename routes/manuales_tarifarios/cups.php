<?php

Route::group(['prefix' => 'cups'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all',  'Cups\CupController@all');               
        Route::put('edit/{cup}',  'Cups\CupController@update');               
        Route::post('cupscapitulo',  'Cups\CupController@cupsCapitulo');
        Route::post('orden/{citapaciente}',  'Cups\CupController@cupsOrden');
        Route::get('servicios',  'Cups\CupController@serviciosOrden');
        Route::get('interconsultas/{citapaciente}',  'Cups\CupController@cupsOrdenInterconsulta');
	});
});