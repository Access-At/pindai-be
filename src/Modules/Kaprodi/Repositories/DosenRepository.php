<?php

namespace Modules\Kaprodi\Repositories;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Prodi;
use Modules\Kaprodi\DataTransferObjects\DosenDto;

class DosenRepository
{
    public static function getAllDosen()
    {
        return User::dosenRole();
    }

    public static function getDosenById($id)
    {
        return User::dosenRole()
            ->with(['dosen' => function ($query) {
                $query->with(['prodi', 'fakultas']);
            }])
            ->byHash($id)
            ->first();
    }

    public static function insertDosen(DosenDto $data)
    {
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'address' => $data->address,
            'nidn' => $data->nidn,
            'password' => $data->password,
        ]);
        $user->assignRole('dosen');

        $prodi = Prodi::byHash($data->prodi_id);

        return Dosen::create([
            'user_id' => $user->id,
            'prodi_id' => $prodi->id,
        ]);
    }

    public static function updateDosen($id, DosenDto $data)
    {
        $user = User::byHash($id);

        $user->update([
            'name' => $data->name ?? $user->name,
            'email' => $data->email ?? $user->email,
            'address' => $data->address ?? $user->address,
            'nidn' => $data->nidn ?? $user->nidn,
        ]);

        return $user->dosen->update([
            'prodi_id' => $data->prodi_id ? Prodi::byHash($data->prodi_id)->id : $user->dosen->prodi_id,
            'name_with_title' => $data->name_with_title ?? $user->dosen->name_with_title,
            'phone_number' => $data->phone_number ?? $user->dosen->phone_number,
            'affiliate_campus' => $data->affiliate_campus ?? $user->dosen->affiliate_campus,
            'job_functional' => $data->job_functional ?? $user->dosen->job_functional,
            'scholar_id' => $data->scholar_id ?? $user->dosen->scholar_id,
            'scopus_id' => $data->scopus_id ?? $user->dosen->scopus_id,
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

    public static function approvedDosen($id)
    {
        $user = User::byHash($id);

        return $user->dosen->update(['is_approved' => true]);
    }

    public static function activeDosen($id, $active)
    {
        $user = User::byHash($id);

        return $user->dosen->update(['is_active' => $active]);
    }
}
