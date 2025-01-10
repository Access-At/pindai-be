<?php

namespace Modules\ListData\Resources;

use Illuminate\Http\Request;
use Modules\CustomResource;

class JenisPengabdianResource extends CustomResource
{
    public function data(Request $request): array
    {
        return [
            'id' => $this->hash,
            'name' => $this->jenis,
            'kriteria' => $this->kriteria,
            'keterangan' => $this->keterangan,
        ];
    }
}
