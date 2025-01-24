<?php

namespace Modules\Dashboard\Interfaces;

use Illuminate\Support\Collection;

interface KeuanganServiceInterface
{
    public function getNumberOfLecturersByFaculty(): Collection;
    public function getOfPenelitian();
    public function getOfPengabdian();
}
