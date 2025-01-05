<?php

namespace Modules\ListData\Repositories;

use App\Enums\ApprovedDosen;
use App\Enums\StatusDosen;
use App\Models\Faculty;
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

    public static function getListDosen($name)
    {
        return User::dosenRole()
            ->with(['dosen.prodi', 'dosen.fakultas'])
            ->orderBy('name', 'asc')
            ->where(function ($query) use ($name) {
                $query->where('name', 'like', "%{$name}%")
                    ->orWhere('nidn', 'like', "%{$name}%");
            })
            ->activeDosen(StatusDosen::Active)
            ->approvedDosen(ApprovedDosen::Approved)
            ->get();
    }
}
