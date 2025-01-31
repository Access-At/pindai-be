<?php

namespace Modules\Dashboard\Repositories;

use App\Models\Faculty;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Enums\StatusPenelitian;
use App\Models\Publikasi;
use sbamtr\LaravelQueryEnrich\QE;
use Illuminate\Support\Collection;

class DppmRepository
{
    public static function getNumberOfLecturersByFaculty(): Collection
    {
        return Faculty::withCount('dosen')
            ->orderBy('dosen_count', 'desc')
            ->take(8)
            ->get()
            ->map(function ($fakultas) {
                return [
                    'name' => $fakultas->name,
                    'dosen_count' => $fakultas->dosen_count,
                ];
            });
    }

    public static function getNumberOfPenelitianByStatus(): Collection
    {
        $result = Penelitian::whereIn('status_dppm', [StatusPenelitian::Approval, StatusPenelitian::Reject])
            ->select(
                QE::c('status_dppm')->as('status'),
                QE::count()->as('count'),
            )
            ->groupBy('status_dppm')
            ->get();

        $statuses = ['accepted', 'rejected'];

        return collect($statuses)->map(function ($status) use ($result) {
            $found = $result->firstWhere('status', $status);

            return [
                'status' => $status,
                'count' => $found ? $found->count : 0,
            ];
        });
    }

    public static function getNewsPenelitian(): Collection
    {
        return Penelitian::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    public static function getNumberOfPengabdianByStatus(): Collection
    {
        $result = Pengabdian::whereIn('status_dppm', [StatusPenelitian::Approval, StatusPenelitian::Reject])
            ->select(
                QE::c('status_dppm')->as('status'),
                QE::count()->as('count'),
            )
            ->groupBy('status_dppm')
            ->get();

        $statuses = ['accepted', 'rejected'];

        return collect($statuses)->map(function ($status) use ($result) {
            $found = $result->firstWhere('status', $status);

            return [
                'status' => $status,
                'count' => $found ? $found->count : 0,
            ];
        });
    }

    public static function getNewsPengabdian(): Collection
    {
        return Pengabdian::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    public static function getNumberOfPublikasiByStatus(): Collection
    {
        $result = Publikasi::whereIn('status_dppm', [StatusPenelitian::Approval, StatusPenelitian::Reject])
            ->select(
                QE::c('status_dppm')->as('status'),
                QE::count()->as('count'),
            )
            ->groupBy('status_dppm')
            ->get();

        $statuses = ['accepted', 'rejected'];

        return collect($statuses)->map(function ($status) use ($result) {
            $found = $result->firstWhere('status', $status);

            return [
                'status' => $status,
                'count' => $found ? $found->count : 0,
            ];
        });
    }

    public static function getNewsPublikasi(): Collection
    {
        return Publikasi::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }
}
