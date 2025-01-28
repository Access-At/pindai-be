<?php

namespace Modules\Dashboard\Services;

use Carbon\CarbonInterval;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Dashboard\Repositories\KeuanganRepository;
use Modules\Dashboard\Interfaces\KeuanganServiceInterface;
use Modules\Dashboard\Resources\PenelitianKeuanganResource;
use Modules\Dashboard\Resources\PengabdianKeuanganResource;

class KeuanganService implements KeuanganServiceInterface
{
    public function getNumberOfLecturersByFaculty(): Collection
    {
        return Cache::remember('dashboard_keuangan_lecture_faculty', CarbonInterval::minutes(5)->totalSeconds, function () {
            return KeuanganRepository::getNumberOfLecturersByFaculty();
        });
    }

    public function getOfPenelitian()
    {
        $data = [
            'news' => PenelitianKeuanganResource::collection(KeuanganRepository::getNewsPenelitian()),
            'status' => KeuanganRepository::getNumberOfPenelitianByStatus(),
        ];

        return Cache::remember('dashboard_keuangan_penelitian', CarbonInterval::minutes(5)->totalSeconds, function () use ($data) {
            return $data;
        });
    }

    public function getOfPengabdian()
    {
        $data = [
            'news' => PengabdianKeuanganResource::collection(KeuanganRepository::getNewsPengabdian()),
            'status' => KeuanganRepository::getNumberOfPengabdianByStatus(),
        ];

        return Cache::remember('dashboard_keuangan_pengabdian', CarbonInterval::minutes(5)->totalSeconds, function () use ($data) {
            return $data;
        });
    }
}
