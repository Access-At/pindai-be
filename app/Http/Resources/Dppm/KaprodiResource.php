<?php

namespace App\Http\Resources\Dppm;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'name' => $this->name,
            'email' => $this->email,
            'nidn' => $this->nidn,
            'address' => $this->address,
            'fakultas_id' => $this->kaprodi->faculty->hash,
            'fakultas' => $this->kaprodi->faculty->name,
            'status' => $this->kaprodi->is_active ? '1' : '0',
        ];
    }
}
