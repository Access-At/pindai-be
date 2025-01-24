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
            'file' => ['required', 'string', new Base64PdfValidation()],
            'category' => [
                'required',
                Rule::in([
                    'pengabdian',
                    'penelitian',
                ])
            ]
        ];
    }
}
