<?php

namespace Modules\Dosen\Requests;

use Modules\CustomRequest;
use Illuminate\Validation\Rule;

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
                    'kontrak_penelitian',
                    'laporan_kemajuan',
                    'laporan',
                    'proposal',
                    'surat_keterangan_selesai',
                    'surat_pengajuan',
                    'surat_rekomendasi',

                    'kontrak_pengabdian',
                ]),
            ],
            'category' => [
                'required',
                Rule::in([
                    'pengabdian',
                    'penelitian',
                ]),
            ],
        ];
    }
}
