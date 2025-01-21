<?php

namespace Modules\Keuangan\DataTransferObjects;

use Modules\Keuangan\Requests\PenelitianRequest;

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
