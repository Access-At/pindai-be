<?php

namespace Modules\Keuangan\Resources;

use Modules\CustomResource;
use Illuminate\Http\Request;

class DetailPublikasiResource extends CustomResource
{
    public function data(Request $request): array
    {
        return [
            // 'id' => $this->hash,
            'judul' => $this->judul,
            'jenis_publikasi' => $this->publikasi->name,
            'kriteria' => $this->kriteria->name,
            'tanggal_publikasi' => $this->tanggal_publikasi,
            'tahun' => $this->tahun,
            'authors' => $this->authors,
            'jurnal' => $this->jurnal,
            'link_publikasi' => $this->link_publikasi,
            'status' => [
                'kaprodi' => $this->status_kaprodi->label(),
                'dppm' => $this->status_dppm->label(),
                'keuangan' => $this->status_keuangan->label(),
            ],
        ];
    }
}
