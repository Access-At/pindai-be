<?php

namespace Modules\Dashboard\Repositories;

use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Enums\StatusPenelitian;
use sbamtr\LaravelQueryEnrich\QE;

class DosenRepository
{
    public static function getNumberOfPenelitianByStatus()
    {
        return self::getStatusCount(Penelitian::class);
    }

    public static function getNumberOfPengbdianByStatus()
    {
        return self::getStatusCount(Pengabdian::class);
    }

    private static function getStatusCount($model)
    {
        $result = $model::select(
            QE::case()
                ->when(
                    QE::condition(
                        QE::c('status_dppm'),
                        '=',
                        StatusPenelitian::Approval->value,
                    ),
                    QE::condition(
                        QE::c('status_kaprodi'),
                        '=',
                        StatusPenelitian::Approval->value,
                    ),
                    QE::condition(
                        QE::c('status_keuangan'),
                        '=',
                        StatusPenelitian::Approval->value,
                    )
                )->then('accepted')
                ->when(
                    QE::raw("
                    (status_dppm = 'rejected' or status_kaprodi = 'rejected' or status_keuangan = 'rejected')"),
                )->then('rejected')
                ->as('status'),
            QE::count()->as('count'),
        )
            ->groupBy('status')
            ->get();

        return self::formatStatusCount($result);
    }

    private static function formatStatusCount($result)
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
}
