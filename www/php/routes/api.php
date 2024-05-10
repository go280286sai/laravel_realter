<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('getFiles', '\App\Http\Controllers\Api\ApiController@getFiles');
    Route::post('getMae', '\App\Http\Controllers\Api\ApiController@getMae');
});
