<?php

namespace App\Http\Resources\Pagination;

use App\Http\Resources\BasePaginationCollection;
use App\Http\Resources\Dppm\KaprodiResource;
use Illuminate\Http\Request;

class KaprodiPaginationCollection extends BasePaginationCollection
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
