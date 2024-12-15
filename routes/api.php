<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\DppmController;
use App\Http\Controllers\KaprodiController;


// Route::prefix()
Route::group(['prefix' => 'v1', 'middleware' => [
    'secure',
    // 'signature',
]], function () {
    Route::get('/', function () {
        return str()->random(32);
    });

    // Auth
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        // Route::post('register', [AuthController::class, 'register']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
        Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
        Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
    });

    // Logined User
    Route::group(['middleware' => ['auth:api']], function () {
        // DPPM
        Route::group(['prefix' => 'dppm', 'middleware' => [
            'role:dppm',
            'secure',
        ]], function () {
            Route::get('/', [DppmController::class, 'index']);
        });

        // Kaprodi
        Route::group(['prefix' => 'kaprodi', 'middleware' => [
            'role:dppm',
        ]], function () {
            Route::get('/', [KaprodiController::class, 'index']);
        });

        // dosen
        Route::group(['prefix' => 'dosen', 'middleware' => [
            'role:dppm',
        ]], function () {
            Route::get('/', [DosenController::class, 'index']);
        });
    });
});
