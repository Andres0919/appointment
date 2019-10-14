<?php

Route::group(['prefix' => 'cups'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',  'Cups\CupController@all');               
        Route::post('cupscapitulo',  'Cups\CupController@cupsCapitulo');
        Route::post('orden',  'Cups\CupController@cupsOrden');
        Route::get('servicios',  'Cups\CupController@serviciosOrden');
        Route::get('interconsultas',  'Cups\CupController@cupsOrdenInterconsulta');
	});
});