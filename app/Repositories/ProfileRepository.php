<?php

namespace App\Repositories;

use App\Models\Faculty;
use App\Models\Prodi;
use App\Models\User;
use App\RepositoriesInterface\ProfileRepositoryInterface;

class ProfileRepository implements ProfileRepositoryInterface
{
    public static function getProfile()
    {
        $user = auth('api')->user();

        $userData = [
            'name' => $user->name,
            'role' => $user->roles->first()->name ?? false,
            'email' => $user->email,
            'nidn' => $user->nidn,
            'address' => $user->address
        ];

        if ($user->roles->first()->name === 'dosen') {
            $userData = array_merge($userData, [
                'name_with_title' => $user->dosen->name_with_title,
                'phone_number' => $user->dosen->phone_number,
                'scholar_id' => $user->dosen->scholar_id,
                'scopus_id' => $user->dosen->scopus_id,
                'job_functional' => $user->dosen->job_functional,
                'affiliate_campus' => $user->dosen->affiliate_campus,
                'prodi' => $user->dosen->prodi->name,
                'prodi_id' => $user->dosen->prodi->hash,
                'fakultas' => $user->dosen->fakultas->name,
                'fakultas_id' => $user->dosen->fakultas->hash,
            ]);
        }

        if ($user->roles->first()->name === 'kaprodi') {
            $userData = array_merge($userData, [
                'fakultas' => $user->kaprodi->faculty->name,
                'fakultas_id' => $user->kaprodi->faculty->hash,
            ]);
        }

        return $userData;
    }

    public static function updateProfile($data)
    {
        $dataLoggined = auth('api')->user();

        $user = User::find($dataLoggined->id);
        $role = $user->roles->first()->name;

        if ($role === 'dosen') {
            $user->dosen->update([
                'user_id' => $user->id,
                'prodi_id' => Prodi::byHash($data['prodi_id'])->id,
                'name_with_title' => $data['name_with_title'] ?? '',
                'phone_number' => $data['phone_number'] ?? '',
                'affiliate_campus' => $data['affiliate_campus'] ?? '',
                'job_functional' => $data['job_functional'] ?? '',
                'scholar_id' => $data['scopus_id'] ?? '',
                'scopus_id' => $data['scopus_id'] ?? '',
            ]);
        }

        if ($role === 'kaprodi') {
            $user->kaprodi->update([
                'faculties_id' => Faculty::byHash($data['fakultas_id'])->id,
                'is_active' => $data['status'],
            ]);
        }

        return $user->update($data);
    }

    public static function changePassword($data)
    {
        //
    }
}
