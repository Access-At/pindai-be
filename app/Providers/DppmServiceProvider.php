<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Dppm\Interfaces\DosenServiceInterface;
use Modules\Dppm\Interfaces\FakultasServiceInterface;
use Modules\Dppm\Interfaces\KaprodiServiceInterface;
use Modules\Dppm\Services\DosenService;
use Modules\Dppm\Services\FakultasService;
use Modules\Dppm\Services\KaprodiService;

class DppmServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DosenServiceInterface::class, DosenService::class);
        $this->app->bind(FakultasServiceInterface::class, FakultasService::class);
        $this->app->bind(KaprodiServiceInterface::class, KaprodiService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
