<?php

namespace App\Repositories;

use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\User;
use App\RepositoriesInterface\DosenRepositoryInterface;

class DosenRepository implements DosenRepositoryInterface
{
    private const ROLE_DOSEN = 'dosen';

    public static function getAllDosen($perPage, $page, $search)
    {
        return User::role(self::ROLE_DOSEN)
            ->with(['dosen.prodi', 'dosen.fakultas'])
            ->orderBy('name', 'asc')
            ->where('name', 'like', "%{$search}%")
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public static function getDosenById($id)
    {
        return User::role(self::ROLE_DOSEN)
            ->with(['dosen.prodi', 'dosen.fakultas'])
            ->byHash($id)
            ->first();
    }

    public static function createDosen($data)
    {
        $user = User::create($data);
        $user->assignRole(self::ROLE_DOSEN);

        $prodi = Prodi::byHash($data['prodi_id']);

        return Dosen::create([
            'user_id' => $user->id,
            'prodi_id' => $prodi->id,
            'name_with_title' => $data['name_with_title'],
            'phone_number' => $data['phone_number'],
            'affiliate_campus' => $data['affiliate_campus'],
            'job_functional' => $data['job_functional'],
            'scholar_id' => $data['scopus_id'],
            'scopus_id' => $data['scopus_id'],
        ]);
    }

    public static function updateDosen($id, $data)
    {
        $user = User::byHash($id);
        $prodi = Prodi::byHash($data['prodi_id']);

        $user->update($data);

        return Dosen::where('user_id', $user->id)
            ->update([
                'prodi_id' => $prodi->id,
                'name_with_title' => $data['name_with_title'],
                'phone_number' => $data['phone_number'],
                'affiliate_campus' => $data['affiliate_campus'],
                'job_functional' => $data['job_functional'],
                'scholar_id' => $data['scopus_id'],
                'scopus_id' => $data['scopus_id'],
            ]);
    }

    public static function deleteDosen($id)
    {
        $user = User::byHash($id);
        $dosen = Dosen::where('user_id', $user->id)->first();

        if ($dosen) {
            $dosen->delete();
            $user->delete();
        }

        return $dosen;
    }
}