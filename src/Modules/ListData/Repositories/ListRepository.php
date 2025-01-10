<?php

namespace Modules\ListData\Repositories;

use App\Enums\ApprovedDosen;
use App\Enums\StatusDosen;
use App\Models\Faculty;
use App\Models\JenisIndeksasi;
use App\Models\JenisPenelitian;
use App\Models\JenisPengabdian;
use App\Models\Prodi;
use App\Models\User;

class ListRepository
{
    public static function getListFakultas()
    {
        return Faculty::orderBy('name', 'asc')->get();
    }

    public static function getListProdi($fakultas)
    {
        $dataFakultas = Faculty::byHash($fakultas);
        return Prodi::where('faculties_id', $dataFakultas->id)->get();
    }

    public static function getListDosen($perPage, $page, $search)
    {
        // NOTE: apakah sesuai fakultas atau prodi si dosen ?

        return User::dosenRole()
            ->with(['dosen.prodi', 'dosen.fakultas'])
            ->orderBy('name', 'asc')
            ->where(function ($query) use ($search) {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('nidn', 'like', "%{$search}%");
            })
            ->activeDosen(StatusDosen::Active)
            ->approvedDosen(ApprovedDosen::Approved)
            ->whereNot('id', auth()->user()->id)
            ->paginate($perPage, ['*'], 'page', $page);
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
