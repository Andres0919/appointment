<?php

Route::group(['prefix' => 'departamento'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
        Route::get('all', 'Departamentos\DepartamentoController@all');
	});
});
// hola 