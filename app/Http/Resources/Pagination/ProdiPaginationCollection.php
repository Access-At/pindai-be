<?php

namespace App\Http\Resources\Pagination;

use Illuminate\Http\Request;
use App\Http\Resources\Kaprodi\ProdiResource;
use App\Http\Resources\BasePaginationCollection;

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
