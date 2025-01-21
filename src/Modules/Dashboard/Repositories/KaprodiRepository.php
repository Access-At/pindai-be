<?php

namespace Modules\Dashboard\Repositories;

use App\Enums\StatusPenelitian;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Penelitian;
use sbamtr\LaravelQueryEnrich\QE;

class KaprodiRepository
{
    public static function getNumberOfPenelitianByStatus()
    {
        $user = auth('api')->user();

        $userLogin = User::where('id', $user->id)
            ->with('kaprodi.faculty')
            ->first();

        $prodi = Prodi::where('faculties_id', $userLogin->kaprodi->faculty->id)
            ->get()
            ->pluck('name');

        return Penelitian::ProdiPenelitian($prodi)
            ->whereIn('status_kaprodi', [StatusPenelitian::Approval, StatusPenelitian::Reject])
            ->select(
                QE::c('status_kaprodi')->as('status'),
                QE::count()->as('count'),
            )
            // ->selectRaw('status_kaprodi as status, COUNT(*) as count')
            ->groupBy('status_kaprodi')
            ->get();
    }
}
