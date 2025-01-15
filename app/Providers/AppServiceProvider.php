<?php

namespace App\Providers;

use Modules\Auth\Services\AuthService;
use Illuminate\Support\ServiceProvider;
use Modules\ListData\Services\ListService;
use Modules\Profile\Services\ProfileService;
use Modules\Auth\Interfaces\AuthServiceInterface;
use Modules\ListData\Interfaces\ListServiceInterface;
use Modules\Profile\Interfaces\ProfileServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // jangan lupa execute "php artisan make:provider" jika ada service baru

        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);
        $this->app->bind(ListServiceInterface::class, ListService::class);

        // dashboard
        $this->app->register(DashboardServiceProvider::class);

        // dppm
        $this->app->register(DppmServiceProvider::class);

        // kaprodi
        $this->app->register(KaprodiServiceProvider::class);

        // dosen
        $this->app->register(DosenServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}
