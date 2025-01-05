<?php

namespace Modules\Dosen\Resources;

use Illuminate\Http\Request;
use Modules\CustomResource;

class PenelitianResource extends CustomResource
{
    public function data(Request $request): array
    {
        return [
            'id' => $this->hash,
            'tahun_akademik' => $this->tahun_akademik,
            // 'semester' => $this->semester,
            // 'judul_penelitian' => $this->judul_penelitian,
            // 'deskripsi' => $this->deskripsi,
            // 'jenis_penelitian' => $this->jenis_penelitian,
            // 'jenis_indeksasi' => $this->jenis_indeksasi,
        ];
    }
}
