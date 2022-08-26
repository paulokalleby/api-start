<?php

use App\Http\Controllers\Auth\{
    AuthController,
    RegisterController,
    ResetPasswordController,
};

use App\Http\Controllers\{
    UserController,
};

use Illuminate\Support\Facades\Route;

/**
 *  Routes Auth
 */
Route::prefix('auth')->group(function () {

    Route::post('/register', [RegisterController::class, 'store']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['guest'])->group(function () {
        Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink']);
        Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

/**
 *  Routes Admin Dashboard
 */
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/users', UserController::class);
});

/**
 *  Route Home
 */
Route::get('/', function () {
    return response()->json(['status' => 'connected']);
});