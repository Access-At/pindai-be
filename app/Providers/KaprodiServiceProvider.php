<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Kaprodi\Interfaces\DosenServiceInterface;
use Modules\Kaprodi\Services\DosenService;

class KaprodiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DosenServiceInterface::class, DosenService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
