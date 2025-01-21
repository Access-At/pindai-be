<?php

namespace Modules\Dashboard\Repositories;

use App\Enums\StatusPenelitian;
use App\Models\Penelitian;
use sbamtr\LaravelQueryEnrich\QE;

class DosenRepository
{
    public static function getNumberOfPenelitianByStatus()
    {
        // CASE
        // WHEN status_dppm = ? OR status_kaprodi = ? OR status_keuangan = ? THEN ?
        // WHEN status_dppm = ? AND status_kaprodi = ? AND status_keuangan = ? THEN ?
        // END as status,

        return Penelitian::select(
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
                ->else('rejected')
                ->as('status'),
            QE::count()->as('count'),
        )
            ->groupBy('status')
            ->get();
    }
}
