<?php

namespace App\Http\Controllers;

use App\Helper\ResponseApi;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function getDashboardDppm()
    {
        return ResponseApi::statusSuccess()
            ->message('Data Dashboard berhasil diambil')
            ->data(DashboardService::getDashboardDppm())
            ->json();
    }

    public function getDashboardDosen()
    {
        return ResponseApi::statusSuccess()
            ->message('Data Dashboard berhasil diambil')
            ->data([])
            ->json();
    }

    public function getDashboardKaprodi()
    {
        return ResponseApi::statusSuccess()
            ->message('Data Dashboard berhasil diambil')
            ->data([])
            ->json();
    }
}
