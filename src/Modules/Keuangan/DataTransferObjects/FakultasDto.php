<?php

namespace Modules\Keuangan\DataTransferObjects;

use Modules\Keuangan\Requests\FakultasRequest;

class FakultasDto
{
    public function __construct(
        public string $name
    ) {}

    public static function fromRequest(FakultasRequest $request): self
    {
        return new self(
            $request->validated('name')
        );
    }
}
