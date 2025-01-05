<?php

namespace Modules\Profile\Resources;

use Illuminate\Http\Request;
use Modules\CustomResource;

class ProfileResource extends CustomResource
{
    public function data(Request $request): array
    {
        $userData = [
            'name' => $this->name,
            'role' => $this->roles->first()->name ?? false,
            'email' => $this->email,
            'nidn' => $this->nidn,
            'address' => $this->address
        ];

        if ($this->roles->first()->name === 'dosen') {
            $userData = array_merge($userData, [
                'name_with_title' => $this->dosen->name_with_title,
                'phone_number' => $this->dosen->phone_number,
                'scholar_id' => $this->dosen->scholar_id,
                'scopus_id' => $this->dosen->scopus_id,
                'job_functional' => $this->dosen->job_functional,
                'affiliate_campus' => $this->dosen->affiliate_campus,
                'prodi' => $this->dosen->prodi->name,
                'prodi_id' => $this->dosen->prodi->hash,
                'fakultas' => $this->dosen->fakultas->name,
                'fakultas_id' => $this->dosen->fakultas->hash,
            ]);
        }

        if ($this->roles->first()->name === 'kaprodi') {
            $userData = array_merge($userData, [
                'fakultas' => $this->kaprodi->faculty->name,
                'fakultas_id' => $this->kaprodi->faculty->hash,
            ]);
        }

        return $userData;
    }
}
