<?php

Route::group(['prefix' => 'tipocita'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all', 'Historia\TipocitaController@all');
        Route::post('create', 'Historia\TipocitaController@store');
	});
});