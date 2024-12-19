<?php

namespace App\Http\Resources\Pagination;

use App\Http\Resources\BasePaginationCollection;
use App\Http\Resources\Dppm\FakultasResource;
use Illuminate\Http\Request;

class FakultasPaginationCollection extends BasePaginationCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
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
