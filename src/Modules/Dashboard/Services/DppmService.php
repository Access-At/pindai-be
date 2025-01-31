<?php

namespace Modules\Dashboard\Services;

use Carbon\CarbonInterval;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Dashboard\Repositories\DppmRepository;
use Modules\Dashboard\Interfaces\DppmServiceInterface;
use Modules\Dashboard\Resources\PenelitianDppmResource;
use Modules\Dashboard\Resources\PengabdianDppmResource;
use Modules\Dashboard\Resources\PublikasiDppmResource;

class DppmService implements DppmServiceInterface
{
    public function getNumberOfLecturersByFaculty(): Collection
    {
        return Cache::remember('dashboard_dppm_lecture_faculty', CarbonInterval::minutes(5)->totalSeconds, function () {
            return DppmRepository::getNumberOfLecturersByFaculty();
        });
    }

    public function getOfPenelitian()
    {
        $data = [
            'news' => PenelitianDppmResource::collection(DppmRepository::getNewsPenelitian()),
            'status' => DppmRepository::getNumberOfPenelitianByStatus(),
        ];

        return Cache::remember('dashboard_dppm_penelitian', CarbonInterval::minutes(5)->totalSeconds, function () use ($data) {
            return $data;
        });
    }

    public function getOfPengabdian()
    {
        $data = [
            'news' => PengabdianDppmResource::collection(DppmRepository::getNewsPengabdian()),
            'status' => DppmRepository::getNumberOfPengabdianByStatus(),
        ];

        return Cache::remember('dashboard_dppm_pengabdian', CarbonInterval::minutes(5)->totalSeconds, function () use ($data) {
            return $data;
        });
    }

    public function getOfPublikasi()
    {
        $data = [
            'news' =>  PublikasiDppmResource::collection(DppmRepository::getNewsPublikasi()),
            'status' => DppmRepository::getNumberOfPublikasiByStatus(),
        ];

        return Cache::remember('dashboard_dppm_publikasi', CarbonInterval::minutes(5)->totalSeconds, function () use ($data) {
            return $data;
        });
    }
}
