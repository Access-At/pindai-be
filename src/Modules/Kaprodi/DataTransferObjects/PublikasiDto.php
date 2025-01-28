<?php

namespace Modules\Kaprodi\DataTransferObjects;

use Modules\Kaprodi\Requests\PublikasiRequest;

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
