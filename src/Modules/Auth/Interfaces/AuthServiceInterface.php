<?php

namespace Modules\Auth\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Modules\Auth\DataTransferObjects\LoginDto;
use Modules\Auth\DataTransferObjects\RegisterDto;

interface AuthServiceInterface
{
    public function login(LoginDto $dto): JsonResponse;
    public function register(RegisterDto $dto): JsonResponse;
    public function refresh();
    public function me(): JsonResponse;
    public function logout(): JsonResponse;
}
