<?php

use App\Helper\ResponseApi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dppm\DosenController;
use App\Http\Controllers\Dppm\FakultasController;
use App\Http\Controllers\Dppm\KaprodiController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\Kaprodi\DosenController as KaprodiDosenController;

Route::group(['prefix' => 'v1', 'middleware' => [
    'secure',
    // 'signature',
]], function () {

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

        // Data List
        Route::group(['prefix' => 'list'], function () {
            Route::get('/fakultas', [ListController::class, 'getListFakultas']);
            Route::get('/prodi/{fakultas}', [ListController::class, 'getListProdi']);
        });

        // DPPM
        Route::group([
            'prefix' => 'dppm',
            'middleware' => ['role:dppm']
        ], function () {
            Route::get('/dashboard', [DashboardController::class, 'getDashboardDppm']);

            // master data
            Route::apiResource('fakultas', FakultasController::class);
            Route::apiResource('kaprodi', KaprodiController::class);
            Route::apiResource('dosen', DosenController::class)->only('index', 'show');
        });

        // Kaprodi
        Route::group([
            'prefix' => 'kaprodi',
            'middleware' => ['role:kaprodi']
        ], function () {
            Route::get('/dashboard', [DashboardController::class, 'getDashboardKaprodi']);

            // master data
            Route::apiResource('dosen', KaprodiDosenController::class)->only('index', 'show', 'store');
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
