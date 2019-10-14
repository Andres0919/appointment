<?php

Route::group(['prefix' => 'departamento'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all', 'Departamentos\DepartamentoController@all');
	});
});
// hola 