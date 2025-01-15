<?php

namespace Modules\ListData\Resources;

use Modules\CustomResource;
use Illuminate\Http\Request;

class JenisIndeksasiResource extends CustomResource
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
