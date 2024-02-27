<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'cors'], function () {
    Route::group([
        'prefix' => '/auth',
    ], function () {
        Route::post('/login', [UserAuthController::class, 'login']);
        Route::post('/generate-otp', [UserAuthController::class, 'generateOTP']);
        Route::post('/verify-otp', [UserAuthController::class, 'verifyOTP']);
        Route::post('/change-password', [UserAuthController::class, 'changePassword']);
        Route::group(['middleware' => 'auth:user'], function () {
            Route::get('/profile-details', [UserAuthController::class, 'getProfileDetails']);
            Route::post('/logout', [UserAuthController::class, 'logout']);
        });
    });
    Route::apiResource('users', UserController::class);
});

Route::apiResource('genres', GenreController::class);
