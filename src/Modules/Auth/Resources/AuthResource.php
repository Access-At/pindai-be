<?php

namespace Modules\Auth\Resources;

use Illuminate\Http\Request;
use Modules\CustomResource;
use Modules\Settings\Models\Setting;


class AuthResource extends CustomResource
{
    public function data(Request $request): array
    {
        $userData = $this->getBaseUserData();

        return match ($userData['role']) {
            'kaprodi' => array_merge($userData, $this->getKaprodiData()),
            'dosen' => array_merge($userData, $this->getDosenData()),
            default => $userData
        };
    }

    private function getBaseUserData(): array
    {
        return [
            'id' => $this->hash,
            'name' => $this->name,
            'email' => $this->email,
            'nidn' => $this->nidn,
            'address' => $this->address,
            'role' => $this->roles->first()->name ?? false,
        ];
    }

    private function getKaprodiData(): array
    {
        return [
            'fakultas_id' => $this->kaprodi->faculty->hash ?? '',
            'fakultas' => $this->kaprodi->faculty->name ?? '',
        ];
    }

    private function getDosenData(): array
    {
        return [
            'name_with_title' => $user->dosen->name_with_title ?? '',
            'phone_number' => $user->dosen->phone_number ?? '',
            'scholar_id' => $user->dosen->scholar_id ?? '',
            'scopus_id' => $user->dosen->scopus_id ?? '',
            'job_functional' => $user->dosen->job_functional ?? '',
            'affiliate_campus' => $user->dosen->affiliate_campus ?? '',
            'prodi_id' => $user->dosen->prodi->hash ?? '',
            'prodi' => $user->dosen->prodi->name ?? '',
        ];
    }
}
