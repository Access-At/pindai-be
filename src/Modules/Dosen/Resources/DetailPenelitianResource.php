<?php

namespace Modules\Dosen\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\CustomResource;
use Illuminate\Support\Str;

class DetailPenelitianResource extends CustomResource
{
    public function data(Request $request): array
    {
        return [
            'id' => $this->hash,
            'title' => $this->judul,
            'anggota' => $this->anggota->map(function ($anggota) {
                $anggota = $anggota->anggotaPenelitian;
                return [
                    'nidn' => $anggota->nidn,
                    'name' => $anggota->name,
                    'name_with_title' => $anggota->name_with_title,
                    'prodi' => $anggota->prodi,
                    'phone_number' => $anggota->phone_number,
                    'email' => $anggota->email,
                    'scholar_id' => $anggota->scholar_id,
                    'scopus_id' => $anggota->scopus_id,
                    'job_functional' => $anggota->job_functional,
                    'affiliate_campus' => $anggota->affiliate_campus,
                    'is_leader' => $anggota->is_leader,
                ];
            }),
            'academic_year' => Str::substr($this->tahun_akademik, 0, 4) . '/' . Str::substr($this->tahun_akademik, 4, 4),
            'created_date' => Carbon::parse($this->created_at)->format('d F Y'),
            'status' => [
                'kaprodi' => $this->status_kaprodi->label(),
                'dppm' => $this->status_dppm->label(),
            ]
        ];
    }
}
