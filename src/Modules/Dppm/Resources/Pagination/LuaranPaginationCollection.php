<?php

namespace Modules\Dppm\Resources\Pagination;

use Illuminate\Http\Request;
use Modules\Dppm\Resources\LuaranResource;
use Modules\CustomPaginationResourceResponse;

class LuaranPaginationCollection extends CustomPaginationResourceResponse
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'luaran' => LuaranResource::collection($this->collection),
            'meta' => parent::toArray($request)['meta'],
            // 'links' => parent::toArray($request)['links'],
        ];
    }
}
