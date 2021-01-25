<?php

use App\Actions\JsonApiAuth\AuthKit;
use App\Http\Controllers\JsonApiAuth\ConfirmablePasswordController;
use App\Http\Controllers\JsonApiAuth\EmailVerificationNotificationController;
use App\Http\Controllers\JsonApiAuth\LoginController;
use App\Http\Controllers\JsonApiAuth\LogoutController;
use App\Http\Controllers\JsonApiAuth\NewPasswordController;
use App\Http\Controllers\JsonApiAuth\PasswordResetLinkController;
use App\Http\Controllers\JsonApiAuth\RegisterController;
use App\Http\Controllers\JsonApiAuth\VerifyEmailController;

Route::post('/register', RegisterController::class)->name('register');

Route::post('/login', LoginController::class)->name('login');

Route::get('/logout', LogoutController::class)
    ->middleware((AuthKit::getMiddleware()))
    ->name('logout');

Route::post('/forgot-password', PasswordResetLinkController::class)
    ->name('password.email');

Route::post('/reset-password', NewPasswordController::class)
    ->name('password.update');

Route::post('/email/verification-notification', EmailVerificationNotificationController::class)
    ->middleware([(AuthKit::getMiddleware()), 'throttle:6,1'])
    ->name('verification.send');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify.byApi');

Route::post('/confirm-password', ConfirmablePasswordController::class)
    ->middleware((AuthKit::getMiddleware()));
