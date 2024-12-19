<?php

use App\Helper\ResponseApi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dppm\FakultasController;
use App\Http\Controllers\Dppm\KaprodiController;

Route::group(['prefix' => 'v1', 'middleware' => [
    'secure',
    // 'signature',
]], function () {

    // Route::get('/test', function () {
    //     return ResponseApi::statusSuccess()->message('Welcome to API')->data([
    //         'message' => 'Welcome to API',
    //         'version' => 'v1',
    //         'timestamp' => now(),
    //         'request' => request()->all(),
    //         'headers' => request()->header(),
    //     ])->json();
    // });

    // Auth
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        // Route::post('register', [AuthController::class, 'register']);
        Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    });


    // Logined User
    Route::group(['middleware' => ['auth:api']], function () {

        Route::get('/me', [AuthController::class, 'me']);

        // DPPM
        Route::group([
            'prefix' => 'dppm',
            'middleware' => ['role:dppm']
        ], function () {
            Route::get('/dashboard', [DashboardController::class, 'getDashboardDppm']);

            Route::apiResource('fakultas', FakultasController::class);
            Route::apiResource('kaprodi', KaprodiController::class);
        });

        // Kaprodi
        Route::group([
            'prefix' => 'kaprodi',
            'middleware' => ['role:kaprodi']
        ], function () {
            Route::get('/dashboard', [DashboardController::class, 'getDashboardKaprodi']);
        });

        // dosen
        Route::group([
            'prefix' => 'dosen',
            'middleware' => ['role:dosen']
        ], function () {
            Route::get('/dashboard', [DashboardController::class, 'getDashboardDosen']);
        });
    });
});
