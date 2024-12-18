<?php

use App\Helper\ResponseApi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\DppmController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\KaprodiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// Route::prefix()
Route::group(['prefix' => 'v1', 'middleware' => [
    'secure',
    'signature',
]], function () {
    Route::get('/test', function () {
        return ResponseApi::statusSuccess()->message('Welcome to API')->data([
            'message' => 'Welcome to API',
            'version' => 'v1',
            'timestamp' => now(),
            'request' => request()->all(),
            'headers' => request()->header(),
        ])->json();
    });

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
        Route::group(['middleware' => [
            'role:dppm',
        ]], function () {
            Route::get('/dashboard', [DashboardController::class, 'getDashboardDppm']);

            Route::group(['prefix' => 'fakultas'], function () {
                Route::get('/', [FakultasController::class, 'index']);
                Route::get('/{id}', [FakultasController::class, 'show']);
                Route::post('/', [FakultasController::class, 'store']);
                Route::put('/{id}', [FakultasController::class, 'update']);
                Route::delete('/{id}', [FakultasController::class, 'destroy']);
            });
        });

        // Kaprodi
        Route::group(['prefix' => 'kaprodi', 'middleware' => [
            'role:dppm',
        ]], function () {
            // Route::get('/', [KaprodiController::class, 'index']);
        });

        // dosen
        Route::group(['prefix' => 'dosen', 'middleware' => [
            'role:dppm',
        ]], function () {
            // Route::get('/', [DosenController::class, 'index']);
        });
    });
});
