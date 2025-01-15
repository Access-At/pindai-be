<?php

namespace Modules\Dashboard\Interfaces;

use Illuminate\Support\Collection;

interface DosenServiceInterface
{
    // TODO: Staticstic PENELITIAN STATUS: SETUJUI, DITOLAK
    // TODO: Staticstic PENGABDIAN STATUS: SETUJUI, DITOLAK

    public function getNumberOfPenelitianByStatus(): Collection;
}
