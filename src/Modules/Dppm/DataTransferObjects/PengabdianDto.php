<?php

namespace Modules\Dppm\DataTransferObjects;

use Modules\Dppm\Requests\PengabdianRequest;

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
