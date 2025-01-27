<?php

namespace Modules\Dppm\DataTransferObjects;

use Modules\Dppm\Requests\LuaranRequest;

class LuaranDto
{
    public function __construct(
        public string $name,
        public string $category,
        public array $kriteria
    ) {}

    public static function fromRequest(LuaranRequest $request): self
    {
        return new self(
            $request->validated('name'),
            $request->validated('category'),
            $request->validated('kriteria')
        );
    }
}
