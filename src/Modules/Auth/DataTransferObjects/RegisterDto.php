<?php

namespace Modules\Auth\DataTransferObjects;

use Modules\Auth\Requests\RegisterRequest;

class RegisterDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}

    public static function fromRequest(RegisterRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password')
        );
    }
}
