<?php

namespace Modules\Dppm\Repositories;

use App\Models\User;

class DosenRepository
{
    public static function getAllDosen($perPage, $page, $search)
    {
        return User::DosenRole()
            ->with(['dosen' => function ($query) {
                $query->with(['prodi', 'fakultas']);
            }])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')
            ->paginate($perPage, ['*'], 'page', $page);
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
