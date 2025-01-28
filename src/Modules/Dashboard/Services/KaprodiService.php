<?php

namespace Modules\Dashboard\Services;

use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Cache;
use Modules\Dashboard\Repositories\KaprodiRepository;
use Modules\Dashboard\Interfaces\KaprodiServiceInterface;

class KaprodiService implements KaprodiServiceInterface
{
    public function getNumberOfPenelitianByStatus()
    {
        return Cache::remember('dashboard_kaprodi_penelitian_status', CarbonInterval::minutes(5)->totalSeconds, function () {
            return KaprodiRepository::getNumberOfPenelitianByStatus();
        });
    }

    public function getNumberOfPengbdianByStatus()
    {
        return Cache::remember('dashboard_kaprodi_pengabdian_status', CarbonInterval::minutes(5)->totalSeconds, function () {
            return KaprodiRepository::getNumberOfPengbdianByStatus();
        });
    }
}
