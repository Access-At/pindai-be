<?php

namespace Modules\Dppm\Resources\Pagination;

use Illuminate\Http\Request;
use Modules\Dppm\Resources\FakultasResource;
use Modules\CustomPaginationResourceResponse;

class FakultasPaginationCollection extends CustomPaginationResourceResponse
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'fakultas' => FakultasResource::collection($this->collection),
            'meta' => parent::toArray($request)['meta'],
            // 'links' => parent::toArray($request)['links'],
        ];
    }
}
