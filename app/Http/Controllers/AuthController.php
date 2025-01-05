<?php

namespace App\Http\Controllers;

use Modules\Auth\DataTransferObjects\LoginDto;
use Modules\Auth\DataTransferObjects\RegisterDto;
use Modules\Auth\Interfaces\AuthServiceInterface;
use Modules\Auth\Requests\LoginRequest;
use Modules\Auth\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $service
    ) {}

    public function login(LoginRequest $request)
    {
        return $this->service->login(
            LoginDto::fromRequest($request)
        );
    }

    // logout
    public function logout()
    {
        return $this->service->logout();
    }

    public function register(RegisterRequest $request)
    {
        return $this->service->register(
            RegisterDto::fromRequest($request)
        );
    }

    // refresh token
    public function refresh()
    {
        return $this->service->refresh();
    }

    public function me()
    {
        return $this->service->me();
    }
}
