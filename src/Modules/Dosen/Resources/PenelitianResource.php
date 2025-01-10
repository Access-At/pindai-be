<?php

namespace Modules\Dosen\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\CustomResource;
use Illuminate\Support\Str;

class PenelitianResource extends CustomResource
{
    public function data(Request $request): array
    {
        return [
            'id' => $this->hash,
            'title' => $this->judul,
            'leader' => $this->ketua,
            'academic_year' => Str::substr($this->tahun_akademik, 0, 4) . '/' . Str::substr($this->tahun_akademik, 4, 4),
            'created_date' => Carbon::parse($this->created_at)->format('d F Y'),
            'status' => [
                'kaprodi' => $this->status_kaprodi->label(),
                'dppm' => $this->status_dppm->label(),
            ]
        ];
    }
}
