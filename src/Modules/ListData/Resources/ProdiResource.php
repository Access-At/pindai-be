<?php

namespace Modules\ListData\Resources;

use Modules\CustomResource;
use Illuminate\Http\Request;

class ProdiResource extends CustomResource
{
    public function data(Request $request): array
    {
        return [
            'id' => $this->hash,
            'name' => $this->name,
        ];
    }
}
