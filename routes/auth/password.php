<?php
    use Illuminate\Http\Request;

    Route::group([ 
        'middleware' => 'api',    
        'prefix' => 'password'
        ], function () {    
            Route::post('create', 'Auth\PasswordResetController@create');
            Route::get('find/{token}', 'Auth\PasswordResetController@find');
            Route::post('reset', 'Auth\PasswordResetController@reset');
    });