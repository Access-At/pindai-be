<?php

namespace Modules\Keuangan\Resources;

use Modules\CustomResource;
use Illuminate\Http\Request;

class KaprodiResource extends CustomResource
{
    public function data(Request $request): array
    {
        return [
            'id' => $this->hash,
            'name' => $this->name,
            'email' => $this->email,
            'nidn' => $this->nidn,
            'address' => $this->address,
            'fakultas_id' => $this->kaprodi->faculty->hash,
            'fakultas' => $this->kaprodi->faculty->name,
            'status' => $this->kaprodi->is_active ? 'true' : 'false',
        ];
    }
}
