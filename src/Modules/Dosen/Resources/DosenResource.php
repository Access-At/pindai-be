<?php

namespace Modules\Dosen\Resources;

use Modules\CustomResource;
use Illuminate\Http\Request;

class DosenResource extends CustomResource
{
    public function data(Request $request): array
    {
        return [
            'nidn' => $this->nidn,
            'name' => $this->name,
            'name_with_title' => $this->dosen->name_with_title,
            'email' => $this->email,
            'phone_number' => $this->dosen->phone_number ?? '',
            'prodi' => $this->dosen->prodi->name ?? '',
            'affiliate_campus' => $this->dosen->affiliate_campus ?? '',
            'job_functional' => $this->dosen->job_functional ?? '',
            'scholar_id' => $this->dosen->scholar_id ?? '',
            'scopus_id' => $this->dosen->scopus_id ?? '',
            'is_leader' => true,
        ];
    }
}
