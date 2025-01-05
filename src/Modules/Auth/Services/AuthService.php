<?php

namespace Modules\Auth\Services;

use App\Enums\Role;
use App\Helper\EncryptData;
use App\Helper\ResponseApi;
use App\Models\Dosen;
use Modules\Auth\DataTransferObjects\LoginDto;
use Modules\Auth\Exceptions\AuthException;
use Modules\Auth\Interfaces\AuthServiceInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Modules\Auth\DataTransferObjects\RegisterDto;
use Modules\Auth\Resources\AuthResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface
{
    public function login(LoginDto $data): JsonResponse
    {
        $user = User::where('email', $data->email)->first();

        if (!$user) throw AuthException::userNotFound();

        if ($user->hasRole(Role::Dosen) && ! $user->dosen->is_active) {
            throw AuthException::dosenNotActive();
        }

        if ($user->hasRole(Role::Dosen) && ! $user->dosen->is_approved) {
            throw AuthException::dosenNotApproved();
        }

        if ($user->hasRole(Role::Kaprodi) && ! $user->kaprodi->is_active) {
            throw AuthException::kaprodiNotActive();
        }

        $exp = 1440;

        if ($data->remember_me) {
            $exp = $this->expires_in_remember();
        }

        if (! $token = auth('api')->setTTL($exp)->attempt([
            'email' => $data->email,
            'password' => $data->password,
        ])) {
            throw AuthException::unauthorized();
        }

        return $this->respondWithToken($token);
    }

    public function register(RegisterDto $data): JsonResponse
    {
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password),
        ]);

        $user->assignRole(Role::Dosen);

        Dosen::create([
            'user_id' => $user->id,
        ]);

        return ResponseApi::statusSuccess()
            ->message('Registrasi berhasil.')
            ->json();
    }

    public function refresh()
    {
        return auth('api')->refresh();
    }

    public function me(): JsonResponse
    {
        if (! auth('api')->check()) {
            throw AuthException::userNotLogined();
        }

        return ResponseApi::statusSuccess()
            ->message('Data berhasil diperoleh.')
            ->data(new AuthResource(auth('api')->user()))
            ->json();
    }

    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return ResponseApi::statusSuccess()
            ->message('Anda telah keluar dari sistem.')
            ->data([])
            ->json();
    }

    protected function respondWithToken($token): JsonResponse
    {
        $user = new AuthResource(auth('api')->user());

        return ResponseApi::statusSuccess()
            ->message('Login berhasil.')
            ->data([
                'user' => EncryptData::encrypt(json_encode($user)),
                'token_type' => 'bearer',
                'access_token' => $token,
            ])->json();
    }

    protected function expires_in_remember(): int
    {
        return Carbon::now()->addYears(2)->getTimestamp();
    }
}
