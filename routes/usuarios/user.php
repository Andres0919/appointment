<?php

Route::group(['prefix' => 'user'], function () {
	Route::group(['middleware' => 'auth:api', 'throttle:60,1'], function() {
		Route::post('create',   'Usuarios\UserController@store');
        Route::get('all',         'Usuarios\UserController@all');  
        Route::get('medicos',        'Usuarios\UserController@medicos');                   
        Route::put('edit/{user}', 'Usuarios\UserController@update');
        Route::post('edit/{user}', 'Usuarios\UserController@updatefirma');
        Route::put('password/{user}', 'Usuarios\UserController@updatepass');
        Route::get('show/{user}',   'Usuarios\UserController@show');
        Route::put('available/{user}', 'Usuarios\UserController@available');
	});
});