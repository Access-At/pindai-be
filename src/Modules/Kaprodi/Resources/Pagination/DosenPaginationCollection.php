<?php

namespace Modules\Kaprodi\Resources\Pagination;

use Illuminate\Http\Request;
use Modules\Dppm\Resources\DosenResource;
use Modules\CustomPaginationResourceResponse;

class DosenPaginationCollection extends CustomPaginationResourceResponse
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'dosen' => DosenResource::collection($this->collection),
            'meta' => parent::toArray($request)['meta'],
            // 'links' => parent::toArray($request)['links'],
        ];
    }
}
