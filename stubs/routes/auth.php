<?php

Route::post('/register', \App\Http\Controllers\JsonApiAuth\RegisterController::class)->name('register');

Route::post('/login', \App\Http\Controllers\JsonApiAuth\LoginController::class)->name('login');

Route::get('/logout', \App\Http\Controllers\JsonApiAuth\LogoutController::class)->middleware('auth:api')->name('logout');

Route::post('/forgot-password', \App\Http\Controllers\JsonApiAuth\PasswordResetLinkController::class)
    ->name('password.email');

Route::post('/reset-password', \App\Http\Controllers\JsonApiAuth\NewPasswordController::class)
    ->name('password.update');
