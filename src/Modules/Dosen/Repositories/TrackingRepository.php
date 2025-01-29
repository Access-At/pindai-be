<?php

namespace Modules\Dosen\Repositories;

use App\Models\Publikasi;
use App\Models\Penelitian;
use App\Models\Pengabdian;

class TrackingRepository
{
    public static function penelitianTracking()
    {
        return Penelitian::myPenelitian();
    }

    public static function publikasiTracking()
    {
        return Publikasi::myPublikasi();
    }

    public static function pengabdianTracking()
    {
        return Pengabdian::myPengabdian();
    }
}
