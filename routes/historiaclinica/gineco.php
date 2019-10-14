<?php

Route::group(['prefix' => 'gineco'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
    Route::get('{citapaciente}/all', 'Historia\GinecologicoController@all');
    Route::post('{citapaciente}/create', 'Historia\GinecologicoController@store');
	});
});