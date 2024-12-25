<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Kaprodi;
use App\RepositoriesInterface\KaprodiRepositoryInterface;

class KaprodiRepository implements KaprodiRepositoryInterface
{
    public static function getAllKaprodi($perPage, $page, $search)
    {
        return User::role('kaprodi')
            ->with(['kaprodi.faculty'])
            ->where('name', 'like', "%{$search}%")
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public static function getKaprodiById($id)
    {
        return User::with(['kaprodi.faculty'])
            ->byHash($id)
            ->first();
    }

    public static function createKaprodi($data)
    {
        $user = User::create($data);
        $user->assignRole('kaprodi');

        $faculty = Faculty::byHash($data['fakultas_id']);

        return Kaprodi::create([
            'user_id' => $user->id,
            'faculties_id' => $faculty->id,
            'is_active' => $data['status'],
        ]);
    }

    public static function updateKaprodi($id, $data)
    {
        $user = User::byHash($id);
        $user->update($data);

        return $user->kaprodi->update([
            'faculties_id' => Faculty::byHash($data['fakultas_id'])->id,
            'is_active' => $data['status'],
        ]);
    }

    public static function deleteKaprodi($id)
    {
        $user = User::byHash($id);
        $kaprodi = Kaprodi::where('user_id', $user->id)->first();

        if ($kaprodi) {
            $kaprodi->delete();
            $user->delete();
        }

        return $kaprodi;
    }
}
