<?php

namespace Modules\Kaprodi\Resources;

use Illuminate\Http\Request;
use Modules\CustomResource;

class DosenResource extends CustomResource
{
    public function data(Request $request): array
    {
        return [
            'id' => $this->hash,
            'name' => $this->name,
            'nidn' => $this->nidn,
            'email' => $this->email,
            'phone_number' => $this->dosen->phone_number ?? '',
            'prodi' => $this->dosen->prodi->name ?? '',
            'prodi_id' => $this->dosen->prodi->hash ?? '',
            'fakultas' => $this->dosen->fakultas->name ?? '',
            'fakultas_id' => $this->dosen->fakultas->hash ?? '',
            'affiliate_campus' => $this->dosen->affiliate_campus ?? '',
            'job_functional' => $this->dosen->job_functional ?? '',
            'scholar_id' => $this->dosen->scholar_id ?? '',
            'scopus_id' => $this->dosen->scopus_id ?? '',
            'is_approved' => $this->dosen->is_approved ?? false,
            'is_active' => $this->dosen->is_active ?? false,
        ];
    }
}
