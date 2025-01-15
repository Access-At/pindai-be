<?php

namespace Modules;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class CustomResource extends JsonResource
{
    abstract public function data(Request $request): array;

    public function toResponse($request): JsonResponse
    {
        return (new CustomResourceResponse($this))->toResponse($request);
    }

    public function toArray(Request $request): array
    {
        if ($this->resource === null) {
            return [];
        }

        return $this->data($request);
    }
}
