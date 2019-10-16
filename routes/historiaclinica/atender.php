<?php

Route::group(['prefix' => 'atender'], function () {

	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {

        Route::get('historiaclinica/{paciente}', 'Citas\CitaController@atender');

	});
});