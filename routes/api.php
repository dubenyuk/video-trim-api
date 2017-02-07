<?php

Route::group(['prefix' => 'v1', 'middleware' => 'auth.basic'], function () {
    Route::get('/video', ['uses' => 'Api\v1\VideoController@index']);
    Route::post('/video', ['uses' => 'Api\v1\VideoController@store']);
    Route::post('/video/restart', ['uses' => 'Api\v1\VideoController@restart']);
    Route::post('/video/frame', ['uses' => 'Api\v1\VideoController@frame']);
});