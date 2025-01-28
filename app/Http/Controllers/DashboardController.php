<?php

namespace App\Http\Controllers;

use App\Helper\ResponseApi;
use Modules\Dashboard\Interfaces\DppmServiceInterface;
use Modules\Dashboard\Interfaces\DosenServiceInterface;
use Modules\Dashboard\Interfaces\KaprodiServiceInterface;
use Modules\Dashboard\Interfaces\KeuanganServiceInterface;

class DashboardController extends Controller
{
    public function __construct(
        protected DosenServiceInterface $serviceDosen,
        protected DppmServiceInterface $serviceDppm,
        protected KaprodiServiceInterface $serviceKaprodi,
        protected KeuanganServiceInterface $serviceKeuangan,
    ) {}

    public function getDashboardDppm()
    {
        return ResponseApi::statusSuccess()
            ->message('Data Dashboard berhasil diambil')
            ->data([
                'fakultas' => $this->serviceDppm->getNumberOfLecturersByFaculty(),
                'penelitian' => $this->serviceDppm->getOfPenelitian(),
                'pengabdian' => $this->serviceDppm->getOfPengabdian(),
            ])
            ->json();
    }

    public function getDashboardKeuangan()
    {
        return ResponseApi::statusSuccess()
            ->message('Data Dashboard berhasil diambil')
            ->data([
                'penelitian' => $this->serviceKeuangan->getOfPenelitian(),
                'pengabdian' => $this->serviceKeuangan->getOfPengabdian(),
            ])
            ->json();
    }

    public function getDashboardDosen()
    {
        return ResponseApi::statusSuccess()
            ->message('Data Dashboard berhasil diambil')
            ->data([
                'penelitian' => $this->serviceDosen->getNumberOfPenelitianByStatus(),
                'pengabdian' => $this->serviceDosen->getNumberOfPengbdianByStatus(),
            ])
            ->json();
    }

    public function getDashboardKaprodi()
    {
        return ResponseApi::statusSuccess()
            ->message('Data Dashboard berhasil diambil')
            ->data([
                'penelitian' => $this->serviceKaprodi->getNumberOfPenelitianByStatus(),
                'pengabdian' => $this->serviceKaprodi->getNumberOfPengbdianByStatus(),
            ])
            ->json();
    }
}
