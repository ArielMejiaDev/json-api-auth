<?php

Route::post('/register', \App\Http\Controllers\JsonApiAuth\RegisterController::class)->name('register');

Route::post('/login', \App\Http\Controllers\JsonApiAuth\LoginController::class)->name('login');

Route::get('/logout', \App\Http\Controllers\JsonApiAuth\LogoutController::class)->middleware('auth:api')->name('logout');

Route::post('/forgot-password', \App\Http\Controllers\JsonApiAuth\PasswordResetLinkController::class)
    ->name('password.email');

Route::post('/reset-password', \App\Http\Controllers\JsonApiAuth\NewPasswordController::class)
    ->name('password.update');

Route::post('/email/verification-notification', \App\Http\Controllers\JsonApiAuth\EmailVerificationNotificationController::class)
    ->middleware(['auth:api', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/verify-email/{id}/{hash}', \App\Http\Controllers\JsonApiAuth\VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify.byApi');


