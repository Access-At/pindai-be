<?php

namespace Modules\Dashboard\Services;

use Illuminate\Support\Collection;
use Modules\Dashboard\Repositories\DppmRepository;
use Modules\Dashboard\Interfaces\DppmServiceInterface;
use Modules\Dashboard\Resources\PenelitianDppmResource;

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
}
