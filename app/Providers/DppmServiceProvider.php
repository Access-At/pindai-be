<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Dppm\Services\DosenService;
use Modules\Dppm\Services\KaprodiService;
use Modules\Dppm\Services\FakultasService;
use Modules\Dppm\Interfaces\DosenServiceInterface;
use Modules\Dppm\Interfaces\KaprodiServiceInterface;
use Modules\Dppm\Interfaces\FakultasServiceInterface;
use Modules\Dppm\Interfaces\LuaranServiceInterface;
use Modules\Dppm\Services\LuaranService;

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
        $this->app->bind(LuaranServiceInterface::class, LuaranService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
