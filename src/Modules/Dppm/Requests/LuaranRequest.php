<?php

namespace Modules\Dppm\Requests;

use Modules\CustomRequest;

class LuaranRequest extends CustomRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'kriteria' => 'required|array',
            'kriteria.*.name' => 'required|string|max:255',
            'kriteria.*.nominal' => 'required|numeric',
            'kriteria.*.keterangan' => 'required|string|max:255',
        ];
    }
}
