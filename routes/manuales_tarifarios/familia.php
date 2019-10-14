<?php

Route::group(['prefix' => 'familia'], function () {
	Route::group(['middleware' => 'auth:api'], function() {
		Route::get('all',  'Tarifarios\FamiliaController@all');
        Route::get('capitulos',  'Tarifarios\FamiliaController@unidadfuncional');		
		Route::post('create',   'Tarifarios\FamiliaController@store');                    
        Route::put('edit/{tarifario}', 'Tarifarios\FamiliaController@update');                  
	});
});