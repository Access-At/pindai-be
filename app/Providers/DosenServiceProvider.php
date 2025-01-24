<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Dosen\Interfaces\DokumentServiceInterface;
use Modules\Dosen\Services\PenelitianService;
use Modules\Dosen\Interfaces\PenelitianServiceInterface;
use Modules\Dosen\Interfaces\PengabdianServiceInterface;
use Modules\Dosen\Services\DokumentService;
use Modules\Dosen\Services\PengabdianService;

class DosenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PenelitianServiceInterface::class, PenelitianService::class);
        $this->app->bind(PengabdianServiceInterface::class, PengabdianService::class);
        $this->app->bind(DokumentServiceInterface::class, DokumentService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
