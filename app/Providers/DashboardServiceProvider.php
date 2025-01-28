<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Dashboard\Services\DppmService;
use Modules\Dashboard\Services\DosenService;
use Modules\Dashboard\Services\KaprodiService;
use Modules\Dashboard\Services\KeuanganService;
use Modules\Dashboard\Interfaces\DppmServiceInterface;
use Modules\Dashboard\Interfaces\DosenServiceInterface;
use Modules\Dashboard\Interfaces\KaprodiServiceInterface;
use Modules\Dashboard\Interfaces\KeuanganServiceInterface;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DosenServiceInterface::class, DosenService::class);
        $this->app->bind(DppmServiceInterface::class, DppmService::class);
        $this->app->bind(KaprodiServiceInterface::class, KaprodiService::class);
        $this->app->bind(KeuanganServiceInterface::class, KeuanganService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
