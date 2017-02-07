<?php

Route::group(['prefix' => 'v1', 'middleware' => 'auth.basic', 'namespace' => 'Api\v1'], function () {
    Route::get('/video', ['uses' => 'VideoController@index']);
    Route::post('/video', ['uses' => 'VideoController@store']);
    Route::post('/video/restart', ['uses' => 'VideoController@restart']);
    Route::post('/video/frame', ['uses' => 'VideoController@frame']);
});