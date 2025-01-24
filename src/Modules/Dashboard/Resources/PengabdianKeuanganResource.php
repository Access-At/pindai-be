<?php

namespace Modules\Dashboard\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\CustomResource;
use Illuminate\Http\Request;

class PengabdianKeuanganResource extends CustomResource
{
    public function data(Request $request): array
    {
        $nameLeader = $this->ketua->name_with_title ?? $this->ketua->name ?? '';

        return [
            'id' => $this->hash,
            'title' => $this->judul,
            'leader' => $nameLeader,
        ];
    }
}
