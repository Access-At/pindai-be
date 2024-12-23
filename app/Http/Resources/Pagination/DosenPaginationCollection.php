<?php

namespace App\Http\Resources\Pagination;

use App\Http\Resources\BasePaginationCollection;
use App\Http\Resources\Dppm\DosenResource;
use Illuminate\Http\Request;

class DosenPaginationCollection extends BasePaginationCollection
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
