<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\MenuController;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get("/user", function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data user',
            'data' => $request->user()
        ]);
    });

    Route::post("/menu", [MenuController::class, 'store']);
    Route::put("/menu/{id_menu}", [MenuController::class, 'update']);
    Route::delete("/menu/{id_menu}", [MenuController::class, 'destroy']);
});

Route::get("/menu", [MenuController::class, 'index']);
Route::get("/menu/image/{id_menu}", [MenuController::class, 'getImage']);
