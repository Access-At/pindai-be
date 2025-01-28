<?php

namespace Modules\Dosen\Resources;

use Modules\CustomResource;
use Illuminate\Http\Request;

class DetailPublikasiResource extends CustomResource
{
    public function data(Request $request): array
    {
        return [
            // 'id' => $this->hash,
            'judul' => $this->judul,
            'author' => $this->authors,
            'tanggal_publikasi' => $this->tanggal_publikasi,
            'jenis_publikasi' => $this->publikasi->hash,
            'luaran_kriteria' => $this->kriteria->hash,
            'jenis_publikasi_label' => $this->publikasi->name,
            'luaran_kriteria_label' => $this->kriteria->name,
            'tahun' => $this->tahun,
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
