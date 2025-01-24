<?php

namespace Modules\Dashboard\Services;

use Modules\Dashboard\Repositories\KaprodiRepository;
use Modules\Dashboard\Interfaces\KaprodiServiceInterface;

class KaprodiService implements KaprodiServiceInterface
{
    public function getNumberOfPenelitianByStatus()
    {
        return KaprodiRepository::getNumberOfPenelitianByStatus();
    }

    public function getNumberOfPengbdianByStatus()
    {
        return KaprodiRepository::getNumberOfPengbdianByStatus();
    }
}
