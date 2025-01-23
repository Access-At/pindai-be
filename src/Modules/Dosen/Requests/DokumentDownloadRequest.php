<?php

namespace Modules\Dosen\Requests;

use Illuminate\Validation\Rule;
use Modules\CustomRequest;

class DokumentDownloadRequest extends CustomRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenis_dokumen' => [
                'required',
                Rule::in([
                    'cover',
                    'surat_pengajuan',
                    'surat_rekomendasi',
                    'proposal',
                    "kontrak_penelitian",
                    "surat_keterangan_selesai"
                ])
            ],
        ];
    }
}
