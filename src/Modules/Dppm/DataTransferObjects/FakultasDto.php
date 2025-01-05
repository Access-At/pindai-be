<?php

namespace Modules\Dppm\DataTransferObjects;

use Modules\Dppm\Requests\FakultasRequest;

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
