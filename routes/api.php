<?php

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
