<?php

namespace Modules\Auth\Resources;

use Modules\CustomResource;
use Illuminate\Http\Request;

class AuthResource extends CustomResource
{
    public function data(Request $request): array
    {
        $thisData = $this->getBaseUserData();

        return match ($thisData['role']) {
            'kaprodi' => array_merge($thisData, $this->getKaprodiData()),
            'dosen' => array_merge($thisData, $this->getDosenData()),
            default => $thisData
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
            'name_with_title' => $this->dosen->name_with_title ?? '',
            'phone_number' => $this->dosen->phone_number ?? '',
            'scholar_id' => $this->dosen->scholar_id ?? '',
            'scopus_id' => $this->dosen->scopus_id ?? '',
            'job_functional' => $this->dosen->job_functional ?? '',
            'affiliate_campus' => $this->dosen->affiliate_campus ?? '',
            'prodi_id' => $this->dosen->prodi->hash ?? '',
            'prodi' => $this->dosen->prodi->name ?? '',
        ];
    }
}
