<?php

namespace Modules\Keuangan\DataTransferObjects;

use Modules\Keuangan\Requests\PengabdianRequest;

class PengabdianDto
{
    public function __construct(
        public string $keterangan,
    ) {}

    public static function fromRequest(PengabdianRequest $request): self
    {
        return new self(
            $request->validated('keterangan'),
        );
    }
}
