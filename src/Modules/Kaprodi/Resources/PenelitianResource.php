<?php

namespace Modules\Kaprodi\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\CustomResource;
use Illuminate\Support\Str;

class PenelitianResource extends CustomResource
{
    public function data(Request $request): array
    {
        $nameLeader = $this->ketua->name_with_title ?? $this->ketua->name ?? "";

        return [
            'id' => $this->hash,
            'title' => $this->judul,
            'leader' => $nameLeader,
            'academic_year' => Str::substr($this->tahun_akademik, 0, 4) . '/' . Str::substr($this->tahun_akademik, 4, 4),
            'created_date' => Carbon::parse($this->created_at)->format('d F Y'),
            'status' => [
                'kaprodi' => $this->status_kaprodi->label(),
                'dppm' => $this->status_dppm->label(),
                'keuangan' => $this->status_keuangan->label(),
            ]
        ];
    }
}
