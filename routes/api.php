<?php

use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(\App\Http\Controllers\Api\AuthApiController::class)
    ->prefix('auth')
    ->group(function () {
       Route::post('register','register');

       Route::post('login','login');
    });


Route::controller(UserApiController::class)
    ->middleware('auth:sanctum')
    ->prefix('user')
    ->group(function () {
        Route::get('list','list');
        Route::get('info','info');
    });
