<?php

namespace Modules\ListData\Resources;

use Illuminate\Http\Request;
use Modules\CustomResource;

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