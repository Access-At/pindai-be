<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Dosen\Services\DokumentService;
use Modules\Dosen\Services\TrackingService;
use Modules\Dosen\Services\PublikasiService;
use Modules\Dosen\Services\PenelitianService;
use Modules\Dosen\Services\PengabdianService;
use Modules\Dosen\Interfaces\DokumentServiceInterface;
use Modules\Dosen\Interfaces\TrackingServiceInterface;
use Modules\Dosen\Interfaces\PublikasiServiceInterface;
use Modules\Dosen\Interfaces\PenelitianServiceInterface;
use Modules\Dosen\Interfaces\PengabdianServiceInterface;

class DosenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PenelitianServiceInterface::class, PenelitianService::class);
        $this->app->bind(PengabdianServiceInterface::class, PengabdianService::class);
        $this->app->bind(PublikasiServiceInterface::class, PublikasiService::class);
        $this->app->bind(DokumentServiceInterface::class, DokumentService::class);
        $this->app->bind(TrackingServiceInterface::class, TrackingService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
