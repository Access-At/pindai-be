<?php

namespace Modules\Kaprodi\Resources\Pagination;

use Illuminate\Http\Request;
use Modules\CustomPaginationResourceResponse;
use Modules\Kaprodi\Resources\PenelitianResource;

class PenelitianPaginationCollection extends CustomPaginationResourceResponse
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'penelitian' => PenelitianResource::collection($this->collection),
            'meta' => parent::toArray($request)['meta'],
            // 'links' => parent::toArray($request)['links'],
        ];
    }
}
