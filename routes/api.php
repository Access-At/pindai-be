<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dppm\DosenController;
use App\Http\Controllers\Dppm\LuaranController;
use App\Http\Controllers\Dppm\KaprodiController;
use App\Http\Controllers\Dppm\FakultasController;
use App\Http\Controllers\Dosen\DokumentController;
use App\Http\Controllers\Dosen\TrackingController;
use App\Http\Controllers\Dosen\PublikasiController;
use App\Http\Controllers\Dosen\PenelitianController;
use App\Http\Controllers\Dosen\PengabdianController;
use App\Http\Controllers\Kaprodi\DosenController as KaprodiDosenController;
use App\Http\Controllers\Dppm\PublikasiController as DppmPublikasiController;
use App\Http\Controllers\Dppm\PenelitianController as DppmPenelitianController;
use App\Http\Controllers\Dppm\PengabdianController as DppmPengabdianController;
use App\Http\Controllers\Kaprodi\PublikasiController as KaprodiPublikasiController;
use App\Http\Controllers\Kaprodi\PenelitianController as KaprodiPenelitianController;
use App\Http\Controllers\Kaprodi\PengabdianController as KaprodiPengabdianController;
use App\Http\Controllers\Keuangan\PublikasiController as KeuanganPublikasiController;
use App\Http\Controllers\Keuangan\PenelitianController as KeuanganPenelitianController;
use App\Http\Controllers\Keuangan\PengabdianController as KeuanganPengabdianController;

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

            Route::get('/jenis-publikasi', [ListController::class, 'getListJenisPublikasi']);
            Route::get('/jenis-penelitian', [ListController::class, 'getListJenisPenelitian']);
            Route::get('/jenis-pengabdian', [ListController::class, 'getListJenisPengabdian']);

            // Route::get('/jenis-luaran/{jenis_penelitian}', [ListController::class, 'getListJenisLuaran']);
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
            Route::apiResource('luaran', LuaranController::class);

            Route::apiResource('dosen', DosenController::class)->only('index', 'show');

            // penelitian
            Route::apiResource('penelitian', DppmPenelitianController::class)->only('index', 'show');
            Route::post('approved/penelitian/{id}', [DppmPenelitianController::class, 'approved']);
            Route::post('canceled/penelitian/{id}', [DppmPenelitianController::class, 'canceled']);

            // pengabdian
            Route::apiResource('pengabdian', DppmPengabdianController::class)->only('index', 'show');
            Route::post('approved/pengabdian/{id}', [DppmPengabdianController::class, 'approved']);
            Route::post('canceled/pengabdian/{id}', [DppmPengabdianController::class, 'canceled']);

            // publikasi
            Route::apiResource('publikasi', DppmPublikasiController::class)->only('index', 'show');
            Route::post('approved/publikasi/{id}', [DppmPublikasiController::class, 'approved']);
            Route::post('canceled/publikasi/{id}', [DppmPublikasiController::class, 'canceled']);
        });

        Route::group([
            'prefix' => 'keuangan',
            'middleware' => ['role:keuangan'],
        ], function () {
            Route::get('/dashboard', [DashboardController::class, 'getDashboardKeuangan']);

            // penelitian
            Route::apiResource('penelitian', KeuanganPenelitianController::class)->only('index', 'show');
            Route::post('approved/penelitian/{id}', [KeuanganPenelitianController::class, 'approved']);
            Route::post('canceled/penelitian/{id}', [KeuanganPenelitianController::class, 'canceled']);

            // pengabdian
            Route::apiResource('pengabdian', KeuanganPengabdianController::class)->only('index', 'show');
            Route::post('approved/pengabdian/{id}', [KeuanganPengabdianController::class, 'approved']);
            Route::post('canceled/pengabdian/{id}', [KeuanganPengabdianController::class, 'canceled']);

            // publikasi
            Route::apiResource('publikasi', KeuanganPublikasiController::class)->only('index', 'show');
            Route::post('approved/publikasi/{id}', [KeuanganPublikasiController::class, 'approved']);
            Route::post('canceled/publikasi/{id}', [KeuanganPublikasiController::class, 'canceled']);
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

            // pengabdian
            Route::apiResource('pengabdian', KaprodiPengabdianController::class)->only('index', 'show');
            Route::post('approved/pengabdian/{id}', [KaprodiPengabdianController::class, 'approved']);
            Route::post('canceled/pengabdian/{id}', [KaprodiPengabdianController::class, 'canceled']);

            // publikasi
            Route::apiResource('publikasi', KaprodiPublikasiController::class)->only('index', 'show');
            Route::post('approved/publikasi/{id}', [KaprodiPublikasiController::class, 'approved']);
            Route::post('canceled/publikasi/{id}', [KaprodiPublikasiController::class, 'canceled']);
        });

        // dosen
        Route::group([
            'prefix' => 'dosen',
            'middleware' => ['role:dosen'],
        ], function () {
            Route::get('/dashboard', [DashboardController::class, 'getDashboardDosen']);

            // main menu
            Route::apiResource('penelitian', PenelitianController::class)->except('update');
            Route::post('penelitian/download/{id}', [DokumentController::class, 'download']);
            Route::post('penelitian/upload/{id}', [DokumentController::class, 'upload']);

            Route::apiResource('pengabdian', PengabdianController::class)->except('update');
            Route::post('pengabdian/download/{id}', [DokumentController::class, 'download']);
            Route::post('pengabdian/upload/{id}', [DokumentController::class, 'upload']);

            Route::apiResource('publikasi', PublikasiController::class);

            // tracking penelitian, pengabdian
            Route::get('/tracking/penelitian', [TrackingController::class, 'penelitianTracking']);
            Route::get('/tracking/publikasi', [TrackingController::class, 'publikasiTracking']);
            Route::get('/tracking/pengabdian', [TrackingController::class, 'pengabdianTracking']);
        });
    });
});
