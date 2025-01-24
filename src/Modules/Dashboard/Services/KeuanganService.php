<?php

namespace Modules\Dashboard\Services;

use Illuminate\Support\Collection;
use Modules\Dashboard\Repositories\KeuanganRepository;
use Modules\Dashboard\Interfaces\KeuanganServiceInterface;
use Modules\Dashboard\Resources\PenelitianKeuanganResource;
use Modules\Dashboard\Resources\PengabdianKeuanganResource;

class KeuanganService implements KeuanganServiceInterface
{
    public function getNumberOfLecturersByFaculty(): Collection
    {
        return KeuanganRepository::getNumberOfLecturersByFaculty();
    }

    public function getOfPenelitian()
    {
        $data = [
            'news' => PenelitianKeuanganResource::collection(KeuanganRepository::getNewsPenelitian()),
            'status' => KeuanganRepository::getNumberOfPenelitianByStatus(),
        ];

        return $data;
    }

    public function getOfPengabdian()
    {
        $data = [
            'news' => PengabdianKeuanganResource::collection(KeuanganRepository::getNewsPengabdian()),
            'status' => KeuanganRepository::getNumberOfPengabdianByStatus(),
        ];

        return $data;
    }
}
