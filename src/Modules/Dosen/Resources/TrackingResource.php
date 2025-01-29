<?php

namespace Modules\Dosen\Resources;

use Carbon\Carbon;
use Modules\CustomResource;
use Illuminate\Http\Request;

class TrackingResource extends CustomResource
{
    public function data(Request $request): array
    {
        return [
            'id' => $this->hash,
            'judul' => $this->judul,
            'kaprodi' => [
                'status' => $this->status_kaprodi->label(),
                'date' => $this->status_kaprodi_date ? Carbon::parse($this->status_kaprodi_date)->locale('id')->isoFormat('D MMMM Y') : null,
                'time' => $this->status_kaprodi_date ? Carbon::parse($this->status_kaprodi_date)->locale('id')->isoFormat('HH:mm') : null,
            ],
            'dppm' => [
                'status' => $this->status_dppm->label(),
                'date' => $this->status_dppm_date ? Carbon::parse($this->status_dppm_date)->locale('id')->isoFormat('D MMMM Y') : null,
                'time' => $this->status_dppm_date ? Carbon::parse($this->status_dppm_date)->locale('id')->isoFormat('HH:mm') : null,
            ],
            'keuangan' => [
                'status' => $this->status_keuangan->label(),
                'date' => $this->status_keuangan_date ? Carbon::parse($this->status_keuangan_date)->locale('id')->isoFormat('D MMMM Y') : null,
                'time' => $this->status_keuangan_date ? Carbon::parse($this->status_keuangan_date)->locale('id')->isoFormat('HH:mm') : null,
            ],
        ];
    }
}
