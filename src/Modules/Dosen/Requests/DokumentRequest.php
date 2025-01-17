<?php

namespace Modules\Dosen\Requests;

use Modules\CustomRequest;

class DokumentRequest extends CustomRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenis_dokumen' => ['required', 'in:cover,surat_pengajuan,surat_rekomendasi'],
        ];
    }
}
