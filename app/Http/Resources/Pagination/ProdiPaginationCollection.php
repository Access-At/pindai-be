<?php

namespace App\Http\Resources\Pagination;

use App\Http\Resources\BasePaginationCollection;
use App\Http\Resources\Kaprodi\ProdiResource;
use Illuminate\Http\Request;

class ProdiPaginationCollection extends BasePaginationCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'prodi' => ProdiResource::collection($this->collection),
            'meta' => parent::toArray($request)['meta'],
            // 'links' => parent::toArray($request)['links'],
        ];
    }
}
