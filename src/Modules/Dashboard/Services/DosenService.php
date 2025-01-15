<?php

namespace Modules\Dashboard\Services;

use Illuminate\Support\Collection;
use Modules\Dashboard\Repositories\DosenRepository;
use Modules\Dashboard\Interfaces\DosenServiceInterface;

class DosenService implements DosenServiceInterface
{
    public function getNumberOfPenelitianByStatus(): Collection
    {
        return DosenRepository::getNumberOfPenelitianByStatus();
    }
}
