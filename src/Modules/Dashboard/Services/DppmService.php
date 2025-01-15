<?php

namespace Modules\Dashboard\Services;

use Illuminate\Support\Collection;
use Modules\Dashboard\Repositories\DppmRepository;
use Modules\Dashboard\Interfaces\DppmServiceInterface;

class DppmService implements DppmServiceInterface
{
    public function getNumberOfLecturersByFaculty(): Collection
    {
        return DppmRepository::getNumberOfLecturersByFaculty();
    }
}
