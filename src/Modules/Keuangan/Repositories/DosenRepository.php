<?php

namespace Modules\Keuangan\Repositories;

use App\Models\User;

class DosenRepository
{
    public static function getAllDosen()
    {
        return User::DosenRole();
    }

    public static function getDosenById($id)
    {
        return User::DosenRole()
            ->with(['dosen' => function ($query) {
                $query->with(['prodi', 'fakultas']);
            }])
            ->byHash($id)
            ->first();
    }
}
