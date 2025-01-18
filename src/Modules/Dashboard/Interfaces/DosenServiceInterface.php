<?php

namespace Modules\Dashboard\Interfaces;

use Illuminate\Support\Collection;

interface DosenServiceInterface
{
    // TODO: Staticstic PENGABDIAN STATUS: SETUJUI, DITOLAK

    public function getNumberOfPenelitianByStatus();
}
