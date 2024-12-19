<?php

namespace App\Http\Resources\Dppm;

use App\Http\Resources\BasePaginationCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class KaprodiResource extends JsonResource
{

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->hash,
            "name" => $this->name,
            "email" => $this->email,
            "nidn" => $this->nidn,
            "address" => $this->address,
            "fakultas" => $this->kaprodi->faculty->name,
            "status" => $this->kaprodi->is_active,
            'status_label' => $this->kaprodi->is_active ? 'Aktif' : 'Tidak Aktif',
        ];
    }
}
