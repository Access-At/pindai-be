<?php

namespace Modules\Dppm\Resources;

use Modules\CustomResource;
use Illuminate\Http\Request;

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
