<?php

namespace Modules\Dppm\Resources;

use Illuminate\Http\Request;
use Modules\CustomResource;

class FakultasResource extends CustomResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function data(Request $request): array
    {
        return [
            'id' => $this->hash,
            'name' => $this->name,
        ];
    }
}
