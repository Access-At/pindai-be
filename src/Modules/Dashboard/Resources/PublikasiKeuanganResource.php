<?php

namespace Modules\Dashboard\Resources;

use Modules\CustomResource;
use Illuminate\Http\Request;

class PublikasiKeuanganResource extends CustomResource
{
    public function data(Request $request): array
    {
        return [
            'id' => $this->hash,
            'title' => $this->judul,
            'author' => $this->authors
        ];
    }
}
