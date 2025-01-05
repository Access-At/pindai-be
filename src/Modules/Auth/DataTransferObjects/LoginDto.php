<?php

namespace Modules\Auth\DataTransferObjects;

use Modules\Auth\Requests\LoginRequest;

class LoginDto
{
    public function __construct(
        public string $email,
        public string $password,
        public ?bool $remember_me,
    ) {}

    public static function fromRequest(LoginRequest $request): self
    {
        return new self(
            $request->validated('email'),
            $request->validated('password'),
            $request->remember_me ?? false
        );
    }
}
