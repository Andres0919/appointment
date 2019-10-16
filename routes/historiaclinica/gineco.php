<?php

Route::group(['prefix' => 'gineco'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
    Route::get('{citapaciente}/all', 'Historia\GinecologicoController@all');
    Route::post('{citapaciente}/create', 'Historia\GinecologicoController@store');
    Route::get('{citapaciente}/gineco', 'Historia\GinecologicoController@getGineco');
	});
});