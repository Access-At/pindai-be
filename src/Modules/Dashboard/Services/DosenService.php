<?php

namespace Modules\Dashboard\Services;

use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Cache;
use Modules\Dashboard\Repositories\DosenRepository;
use Modules\Dashboard\Interfaces\DosenServiceInterface;

class DosenService implements DosenServiceInterface
{
    public function getNumberOfPenelitianByStatus()
    {
        return Cache::remember('dashboard_dosen_penelitian_status', CarbonInterval::minutes(5)->totalSeconds, function () {
            return DosenRepository::getNumberOfPenelitianByStatus();
        });
    }

    public function getNumberOfPengbdianByStatus()
    {
        return Cache::remember('dashboard_dosen_pengabdian_status', CarbonInterval::minutes(5)->totalSeconds, function () {
            return DosenRepository::getNumberOfPengbdianByStatus();
        });
    }
}
