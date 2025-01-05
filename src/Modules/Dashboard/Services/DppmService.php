<?php

namespace Modules\Dashboard\Services;

use Illuminate\Support\Collection;
use Modules\Dashboard\Interfaces\DppmServiceInterface;
use Modules\Dashboard\Repositories\DppmRepository;

class DppmService implements DppmServiceInterface
{
    public function getNumberOfLecturersByFaculty(): Collection
    {
        return DppmRepository::getNumberOfLecturersByFaculty();
    }
}
