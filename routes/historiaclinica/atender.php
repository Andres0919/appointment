<?php

Route::group(['prefix' => 'atender'], function () {

	Route::group(['middleware' => 'auth:api'], function() {

        Route::get('historiaclinica/{paciente}', 'Citas\CitaController@atender');

	});
});