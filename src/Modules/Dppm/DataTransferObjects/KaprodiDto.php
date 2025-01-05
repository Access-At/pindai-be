<?php

namespace Modules\Dppm\DataTransferObjects;

use Modules\Dppm\Requests\KaprodiRequest;

class KaprodiDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $nidn,
        public string $address,
        public string $fakultas_id,
        public bool $status,
        public ?string $password
    ) {}

    public static function fromRequest(KaprodiRequest $request): self
    {
        return new self(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('nidn'),
            $request->validated('address'),
            $request->validated('fakultas_id'),
            $request->validated('status'),
            $request->password
        );
    }
}
