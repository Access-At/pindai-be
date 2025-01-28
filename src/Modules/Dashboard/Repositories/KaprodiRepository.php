<?php

namespace Modules\Dashboard\Repositories;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Enums\StatusPenelitian;
use sbamtr\LaravelQueryEnrich\QE;

class KaprodiRepository
{
    public static function getNumberOfPenelitianByStatus()
    {
        $prodi = self::getUserProdi();
        $result = self::getStatusCount(Penelitian::class, $prodi);

        return self::formatStatusCounts($result);
    }

    public static function getNumberOfPengbdianByStatus()
    {
        $prodi = self::getUserProdi();
        $result = self::getStatusCount(Pengabdian::class, $prodi);

        return self::formatStatusCounts($result);
    }

    private static function getUserProdi()
    {
        $user = auth('api')->user();
        $userLogin = User::where('id', $user->id)
            ->with('kaprodi.faculty')
            ->first();

        return Prodi::where('faculties_id', $userLogin->kaprodi->faculty->id)
            ->get()
            ->pluck('name');
    }

    private static function formatStatusCounts($result)
    {
        $statuses = ['accepted', 'rejected'];

        return collect($statuses)->map(function ($status) use ($result) {
            $found = $result->firstWhere('status', $status);

            return [
                'status' => $status,
                'count' => $found ? $found->count : 0,
            ];
        });
    }

    private static function getStatusCount($query, $prodi)
    {
        return $query::prodiPengabdian($prodi)
            ->whereIn('status_kaprodi', [StatusPenelitian::Approval, StatusPenelitian::Reject])
            ->select(
                QE::c('status_kaprodi')->as('status'),
                QE::count()->as('count'),
            )
            ->groupBy('status_kaprodi')
            ->get();
    }
}
