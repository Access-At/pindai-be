<?php

namespace Modules\Dosen\Requests;

use App\Rules\Base64PdfValidation;
use Illuminate\Validation\Rule;
use Modules\CustomRequest;

class DokumentUploadRequest extends CustomRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => ['required', 'array'],
            'file.base64' => [
                'required',
                'string',
                new Base64PdfValidation(),
            ],
            // 'file.type' => [
            //     'required',
            //     // Rule::in(['pdf', 'image']),
            // ]
        ];
    }
}
