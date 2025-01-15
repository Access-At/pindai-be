<?php

namespace Modules\Dashboard\Interfaces;

use Illuminate\Support\Collection;

interface DppmServiceInterface
{
    public function getNumberOfLecturersByFaculty(): Collection;
    public function getOfPenelitian();
}
