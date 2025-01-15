<?php

namespace Modules\Profile\Repositories;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Faculty;
use Modules\Profile\DataTransferObjects\ProfileDto;

class ProfileRepository
{
    public static function getProfile()
    {
        return auth('api')->user();
    }

    public static function updateProfile(ProfileDto $data)
    {
        $dataLoggined = auth('api')->user();

        $user = User::find($dataLoggined->id);
        $role = $user->roles->first()->name;

        if ($role === 'dosen') {
            $user->dosen->update([
                'user_id' => $user->id,
                'prodi_id' => Prodi::byHash($data->prodi_id)->id,
                'name_with_title' => $data->name_with_title ?? $user->dosen->name_with_title,
                'phone_number' => $data->phone_number ?? $user->dosen->phone_number,
                'affiliate_campus' => $data->affiliate_campus ?? $user->dosen->affiliate_campus,
                'job_functional' => $data->job_functional ?? $user->dosen->job_functional,
                'scholar_id' => $data->scholar_id ?? $user->dosen->scholar_id,
                'scopus_id' => $data->scopus_id ?? $user->dosen->scopus_id,
            ]);
        }

        if ($role === 'kaprodi') {
            $user->kaprodi->update([
                'faculties_id' => Faculty::byHash($data->fakultas_id)->id ?? $user->kaprodi->faculties_id,
            ]);
        }

        return $user->update([
            'name' => $data->name ?? $user->name,
            'email' => $data->email ?? $user->email,
            'nidn' => $data->nidn ?? $user->nidn,
            'address' => $data->address ?? $user->address,
        ]);
    }
}
