<?php

namespace App\Services;

use App\Repositories\FakultasRepository;

class DashboardService
{
    public static function getDashboardDppm()
    {
        $countLecturersByFaculty = FakultasRepository::getNumberOfLecturersByFaculty();

        return [
            'fakultas' => $countLecturersByFaculty,
        ];
    }

    public function getDashboardDosen()
    {
        // return view('dashboard');
    }

    public function getDashboardKaprodi() {}
}
