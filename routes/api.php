<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth.basic'], function () {
    Route::get('/test',['uses' => 'Api\v1\TestController@test']);
    Route::get('/video', ['uses' => 'Api\v1\VideoController@index']);
    Route::post('/video', ['uses' => 'Api\v1\VideoController@store']);
});