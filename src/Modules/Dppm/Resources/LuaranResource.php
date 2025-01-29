<?php

namespace Modules\Dppm\Resources;

use Modules\CustomResource;
use Illuminate\Http\Request;

class LuaranResource extends CustomResource
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
            'category' => $this->category,
            'kriteria' => LuaranKriteriaResource::collection($this->kriteria),
        ];
    }
}
