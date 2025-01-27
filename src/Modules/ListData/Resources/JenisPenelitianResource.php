<?php

namespace Modules\ListData\Resources;

use App\Models\LuaranKriteria;
use Modules\CustomResource;
use Illuminate\Http\Request;

class JenisPenelitianResource extends CustomResource
{
    public function data(Request $request): array
    {
        return [
            'id' => $this->hash,
            'name' => $this->name,
            'kriteria' => LuaranKriteriaResource::collection($this->kriteria),
        ];
    }
}
