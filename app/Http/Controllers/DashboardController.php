<?php

namespace App\Http\Controllers;

use App\Helper\ResponseApi;
use Modules\Dashboard\Interfaces\DppmServiceInterface;
use Modules\Dashboard\Interfaces\DosenServiceInterface;
use Modules\Dashboard\Interfaces\KaprodiServiceInterface;

class DashboardController extends Controller
{
    public function __construct(
        protected DosenServiceInterface $serviceDosen,
        protected DppmServiceInterface $serviceDppm,
        protected KaprodiServiceInterface $serviceKaprodi,
    ) {}

    public function getDashboardDppm()
    {
        return ResponseApi::statusSuccess()
            ->message('Data Dashboard berhasil diambil')
            ->data([
                'fakultas' => $this->serviceDppm->getNumberOfLecturersByFaculty(),
                'penelitian' => $this->serviceDppm->getOfPenelitian(),
            ])
            ->json();
    }

    public function getDashboardKeuangan() {}

    public function getDashboardDosen()
    {
        return ResponseApi::statusSuccess()
            ->message('Data Dashboard berhasil diambil')
            ->data([
                'penelitian' => $this->serviceDosen->getNumberOfPenelitianByStatus(),
            ])
            ->json();
    }

    public function getDashboardKaprodi()
    {
        return ResponseApi::statusSuccess()
            ->message('Data Dashboard berhasil diambil')
            ->data([
                'penelitian' => $this->serviceKaprodi->getNumberOfPenelitianByStatus(),
            ])
            ->json();
    }
}
