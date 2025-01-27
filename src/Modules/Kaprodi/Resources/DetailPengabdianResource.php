<?php

namespace Modules\Kaprodi\Resources;

use Illuminate\Support\Str;
use Modules\CustomResource;
use Illuminate\Http\Request;

class DetailPengabdianResource extends CustomResource
{
    public function data(Request $request): array
    {
        $nameLeader = $this->ketua->name_with_title ?? $this->ketua->name;

        return [
            // 'id' => $this->hash,
            'title' => $this->judul,
            'leader' => [
                'name' => $nameLeader,
                'prodi' => $this->ketua->prodi,
            ],
            'bidang' => $this->bidang,
            'jenis_pengabdian' => $this->kriteria->luaran->name,
            'jenis_kriteria' => $this->kriteria->name,
            'semester' => $this->semester->label(),
            'academic_year' => Str::substr($this->tahun_akademik, 0, 4) . '/' . Str::substr($this->tahun_akademik, 4, 4),
            'keterangan' => $this->keterangan,
            'anggota' => $this->anggota->map(function ($anggota) {
                $anggota = $anggota->anggotaPengabdian;

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
            // 'created_date' => Carbon::parse($this->created_at)->format('d F Y'),
            'status' => [
                'kaprodi' => $this->status_kaprodi->label(),
                'dppm' => $this->status_dppm->label(),
                'keuangan' => $this->status_keuangan->label(),
            ],
        ];
    }
}
