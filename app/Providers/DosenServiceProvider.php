<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Dosen\Interfaces\PenelitianServiceInterface;
use Modules\Dosen\Services\PenelitianService;

class DosenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PenelitianServiceInterface::class, PenelitianService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
