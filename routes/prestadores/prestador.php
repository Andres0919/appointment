<?php

Route::group(['prefix' => 'prestador'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
        Route::get('all',         'Tarifarios\PrestadorController@all');
        Route::get('prestadoresmedicamentos',         'Tarifarios\PrestadorController@prestadoresmedicamentos');
		Route::post('create',   'Tarifarios\PrestadorController@store');
        Route::get('prestadores',         'Tarifarios\PrestadorController@prestadores');
        Route::put('edit/{prestadore}', 'Tarifarios\PrestadorController@update');
        Route::get('show/{prestadore}',   'Tarifarios\PrestadorController@show');
        Route::put('available/{prestadore}', 'Tarifarios\PrestadorController@available');
        Route::put('disable/{prestadore}', 'Tarifarios\PrestadorController@disable');
        Route::get('enabled', 'Tarifarios\PrestadorController@enabled');
        Route::post('import', 'Tarifarios\PrestadorController@import');

        Route::post('{prestadore}/codepropio/create',   'Tarifarios\CodepropioController@store');
        Route::get('{prestadore}/enabled', 'Tarifarios\CodepropioController@enabled');
		Route::get('{prestadore}/codepropio/habilitados', 'Tarifarios\CodepropioController@habilitados');
        Route::put('{prestadore}/codepropio/edit/{codepropio}',   'Tarifarios\CodepropioController@update');
        Route::put('{prestadore}/codepropio/edit/{codepropio}',   'Tarifarios\CodepropioController@update');


        Route::post('{codepropio}/valorpropio/create',   'Valorpropio\ValorpropioController@store');
		Route::get('{codepropio}/valorpropio/all',   'Valorpropio\ValorpropioController@all');
        Route::put('{codepropio}/valorpropio/edit/{valorpropio}',   'Valorpropio\ValorpropioController@update');
        
		Route::get('tipoprestador/all',   'Proveedores\TipoprestadorController@all');
        Route::post('tipoprestador/create',   'Proveedores\TipoprestadorController@store');
		Route::put('tipoprestador/edit/{tipoprestador}',   'Proveedores\TipoprestadorController@update');
	});
});