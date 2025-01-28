<?php

namespace Modules\Dppm\DataTransferObjects;

use Modules\Dppm\Requests\PublikasiRequest;

class PublikasiDto
{
    public function __construct(
        public string $keterangan,
    ) {}

    public static function fromRequest(PublikasiRequest $request): self
    {
        return new self(
            $request->validated('keterangan'),
        );
    }
}
