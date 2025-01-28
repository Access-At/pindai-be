<?php

namespace Modules\Keuangan\Resources\Pagination;

use Illuminate\Http\Request;
use Modules\CustomPaginationResourceResponse;
use Modules\Keuangan\Resources\KaprodiResource;

class KaprodiPaginationCollection extends CustomPaginationResourceResponse
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'kaprodi' => KaprodiResource::collection($this->collection),
            'meta' => parent::toArray($request)['meta'],
            // 'links' => parent::toArray($request)['links'],
        ];
    }
}
