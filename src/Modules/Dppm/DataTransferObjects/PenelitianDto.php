<?php

namespace Modules\Dppm\DataTransferObjects;

use Modules\Dppm\Requests\PenelitianRequest;

class PenelitianDto
{
    public function __construct(
        public string $keterangan,
    ) {}

    public static function fromRequest(PenelitianRequest $request): self
    {
        return new self(
            $request->validated('keterangan'),
        );
    }
}
