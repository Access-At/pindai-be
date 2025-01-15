<?php

namespace Modules\Dppm\Requests;

use Modules\CustomRequest;

class FakultasRequest extends CustomRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
