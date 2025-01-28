<?php

namespace Modules\Dosen\Requests;

use Modules\CustomRequest;
use Illuminate\Validation\Rule;
use App\Rules\Base64PdfValidation;

class DokumentUploadRequest extends CustomRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => ['required', 'string', new Base64PdfValidation],
            'category' => [
                'required',
                Rule::in([
                    'pengabdian',
                    'penelitian',
                ]),
            ],
            'jenis_dokumen' => [
                'sometimes',
                Rule::in([
                    'cover',
                    'surat_pengajuan',
                    'surat_rekomendasi',
                    'proposal',
                    'kontrak_penelitian',
                    'kontrak_pengabdian',
                    'surat_keterangan_selesai',
                    'laporan_kemajuan',
                    'laporan',
                ]),
            ],
        ];
    }
}
