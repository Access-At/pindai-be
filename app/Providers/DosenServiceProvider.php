<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\CommonMark\Node\Block\Document;
use Modules\Dosen\Interfaces\DokumentServiceInterface;
use Modules\Dosen\Services\PenelitianService;
use Modules\Dosen\Interfaces\PenelitianServiceInterface;
use Modules\Dosen\Services\DokumentService;

class DosenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PenelitianServiceInterface::class, PenelitianService::class);
        $this->app->bind(DokumentServiceInterface::class, DokumentService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
