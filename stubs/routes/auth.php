<?php

Route::post('/register', \App\Http\Controllers\JsonApiAuth\RegisterController::class)->name('register');

Route::post('/login', \App\Http\Controllers\JsonApiAuth\LoginController::class)->name('login');

Route::get('/logout', \App\Http\Controllers\JsonApiAuth\LogoutController::class)->middleware('auth:api')->name('logout');
