<?php

Route::group(['prefix' => 'categoria'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
		Route::post('create',   'Categorias\CategoriaController@store');
        Route::get('all',         'Categorias\CategoriaController@all');                   
        Route::put('edit/{estado}', 'Categorias\CategoriaController@update');
	});
});