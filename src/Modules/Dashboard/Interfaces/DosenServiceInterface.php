<?php

namespace Modules\Dashboard\Interfaces;

use Illuminate\Support\Collection;

interface DosenServiceInterface
{
    public function getNumberOfPenelitianByStatus();
    public function getNumberOfPengbdianByStatus();
}
