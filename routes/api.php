<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;

// API v1 routes --------------------------------------------------------------------------

// User Register ----------------------------------------------------------------------
Route::middleware('throttle:5,1')->controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('resend-otp', 'resendOtp');
    Route::post('verify-otp', 'verifyRegisterOtp');
});

// User Login -------------------------------------------------------------------------
Route::middleware('throttle:5,1')->controller(LoginController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('forgot-password', 'forgotPassword');
    Route::post('verify-reset-otp', 'verifyOtp');
    Route::post('reset-resend-otp', 'resendOtp');
    Route::post('reset-password', 'resetPassword');
});

// Social Login -------------------------------------------------------------------------
Route::post('social-login', [SocialAuthController::class, 'socialLogin'])->middleware('throttle:5,1');

// Protected routes -------------------------------------------------------------------
Route::middleware(['auth:sanctum', 'enabled'])->group(function () {
    // Authenticated User -------------------------------------------------------------
    Route::controller(AuthController::class)->group(function () {
        Route::apiResource('users', AuthController::class)->only(['index', 'show']);
        Route::post('change-password', 'changePassword');
        Route::put('update-profile', 'updateProfile');
        Route::get('profile', 'profile');
        Route::post('logout', 'logout');
        Route::post('logout-all', 'logoutAll');
        Route::delete('delete-account', 'destroy');
    });
});
