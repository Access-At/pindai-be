<?php

namespace Modules\Dashboard\Services;

use Illuminate\Support\Collection;
use Modules\Dashboard\Repositories\DppmRepository;
use Modules\Dashboard\Interfaces\DppmServiceInterface;
use Modules\Dashboard\Resources\PenelitianDppmResource;
use Modules\Dashboard\Resources\PengabdianDppmResource;

class DppmService implements DppmServiceInterface
{
    public function getNumberOfLecturersByFaculty(): Collection
    {
        return DppmRepository::getNumberOfLecturersByFaculty();
    }

    public function getOfPenelitian()
    {
        $data = [
            'news' => PenelitianDppmResource::collection(DppmRepository::getNewsPenelitian()),
            'status' => DppmRepository::getNumberOfPenelitianByStatus(),
        ];

        return $data;
    }

    public function getOfPengabdian()
    {
        $data = [
            'news' => PengabdianDppmResource::collection(DppmRepository::getNewsPengabdian()),
            'status' => DppmRepository::getNumberOfPengabdianByStatus(),
        ];

        return $data;
    }
}
