<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dosen\DokumentController;
use App\Http\Controllers\Dppm\DosenController;
use App\Http\Controllers\Dppm\KaprodiController;
use App\Http\Controllers\Dppm\FakultasController;
use App\Http\Controllers\Dosen\PenelitianController;
use App\Http\Controllers\Dppm\PenelitianController as DppmPenelitianController;
use App\Http\Controllers\Kaprodi\DosenController as KaprodiDosenController;
use App\Http\Controllers\Kaprodi\PenelitianController as KaprodiPenelitianController;

Route::group(['prefix' => 'v1', 'middleware' => [
    // 'signature',
    'secure',
]], function () {

    // Auth
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    });

    // Logined User
    Route::group(['middleware' => ['auth:api']], function () {

        // profile
        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', [ProfileController::class, 'getProfile']);
            Route::put('/', [ProfileController::class, 'updateProfile']);
            // Route::put('/password', [ProfileController::class, 'updatePassword']);
        });

        // Data List
        Route::group(['prefix' => 'list'], function () {
            Route::get('/fakultas', [ListController::class, 'getListFakultas']);
            Route::get('/prodi/{fakultas}', [ListController::class, 'getListProdi']);
            Route::get('/dosen', [ListController::class, 'getListDosen']);
            Route::get('/author-scholar', [ListController::class, 'getAuthorScholar']);
            Route::get('/author-scholar/{id}', [ListController::class, 'getAuthorProfileScholar']);

            Route::get('/jenis-indeksasi', [ListController::class, 'getListJenisIndeksasi']);
            Route::get('/jenis-penelitian', [ListController::class, 'getListJenisPenelitian']);
            Route::get('/jenis-pengabdian', [ListController::class, 'getListJenisPengambdian']);
        });

        // DPPM
        Route::group([
            'prefix' => 'dppm',
            'middleware' => ['role:dppm'],
        ], function () {
            Route::get('/dashboard', [DashboardController::class, 'getDashboardDppm']);

            // master data
            Route::apiResource('fakultas', FakultasController::class);
            Route::apiResource('kaprodi', KaprodiController::class);
            Route::apiResource('dosen', DosenController::class)->only('index', 'show');

            // penelitian
            Route::apiResource('penelitian', DppmPenelitianController::class)->only('index', 'show');
            Route::post('approved/penelitian/{id}', [DppmPenelitianController::class, 'approved']);
            Route::post('canceled/penelitian/{id}', [DppmPenelitianController::class, 'canceled']);
        });

        // Kaprodi
        Route::group([
            'prefix' => 'kaprodi',
            'middleware' => ['role:kaprodi'],
        ], function () {
            Route::get('/dashboard', [DashboardController::class, 'getDashboardKaprodi']);

            // master data
            Route::apiResource('dosen', KaprodiDosenController::class)->only('index', 'show');
            Route::post('approved/dosen/{id}', [KaprodiDosenController::class, 'approved']);
            Route::post('active/dosen/{id}', [KaprodiDosenController::class, 'active']);

            // penelitian
            Route::apiResource('penelitian', KaprodiPenelitianController::class)->only('index', 'show');
            Route::post('approved/penelitian/{id}', [KaprodiPenelitianController::class, 'approved']);
            Route::post('canceled/penelitian/{id}', [KaprodiPenelitianController::class, 'canceled']);
        });

        // dosen
        Route::group([
            'prefix' => 'dosen',
            'middleware' => ['role:dosen'],
        ], function () {
            // main menu
            Route::apiResource('penelitian', PenelitianController::class)->except('destroy');
            Route::post('penelitian/download/{id}', [DokumentController::class, 'download']);

            Route::get('/dashboard', [DashboardController::class, 'getDashboardDosen']);
        });
    });
});
