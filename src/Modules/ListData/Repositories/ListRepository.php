<?php

namespace Modules\ListData\Repositories;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Faculty;
use App\Enums\StatusDosen;
use App\Enums\ApprovedDosen;
use App\Models\JenisIndeksasi;
use App\Models\JenisPenelitian;
use App\Models\JenisPengabdian;

class ListRepository
{
    public static function getListFakultas()
    {
        return Faculty::orderBy('name', 'asc')
            ->get();
    }

    public static function getListProdi($fakultas)
    {
        $dataFakultas = Faculty::byHash($fakultas);

        return Prodi::where('faculties_id', $dataFakultas->id)->get();
    }

    public static function getListDosen()
    {
        return User::dosenRole()
            ->activeDosen(StatusDosen::Active)
            ->approvedDosen(ApprovedDosen::Approved)
            ->whereNot('id', auth()->user()->id)
            ->dosenNotNullProfile();
    }

    public static function getListJenisIndeksasi()
    {
        return JenisIndeksasi::get();
    }

    public static function getListJenisPenelitian()
    {
        return JenisPenelitian::get();
    }

    public static function getListJenisPengambdian()
    {
        return JenisPengabdian::get();
    }
}
