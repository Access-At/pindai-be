<?php

namespace Modules\Dppm\Repositories;

use App\Models\User;

class DosenRepository
{
    public static function getAllDosen($perPage, $page, $search)
    {
        return User::role('dosen')
            ->with(['dosen.prodi', 'dosen.fakultas', 'dosen'])
            ->orderBy('name', 'asc')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public static function getDosenById($id)
    {
        return User::role('dosen')
            ->with(['dosen.prodi', 'dosen.fakultas', 'dosen'])
            ->byHash($id)
            ->first();
    }
}
