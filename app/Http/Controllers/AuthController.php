<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Helper\ResponseApi;
use App\Helper\SecureCommunication;
use App\Http\Requests\AuthRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $email = User::where('email', $request->email)->first();

        if (! $email) {
            return ResponseApi::statusQueryError()->message('Login gagal.')->data([
                'email' => 'Email tidak ditemukan.',
            ])->json();
        }

        $exp = 1440;

        if ($request->remember_me) {
            $exp = $this->expires_in_remember();
        }

        if (! $token = auth('api')->setTTL($exp)->attempt($request->validated())) {
            return ResponseApi::statusQueryError()->message('Email / Password anda salah!')->json();
        }

        return $this->respondWithToken($token);
    }

    // logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return ResponseApi::statusSuccess()
            ->message('Anda telah keluar dari sistem.')
            ->data([])
            ->json();
    }

    public function register(AuthRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($user) {
            return ResponseApi::statusSuccess()
                ->message('Registrasi berhasil.')
                ->data($user)
                ->json();
        }

        return ResponseApi::statusQueryError()
            ->message('Registrasi gagal.')
            ->json();
    }

    // refresh token
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function me()
    {
        if (! auth('api')->check()) {
            return ResponseApi::statusQueryError()
                ->message('Unauthorized.')
                ->json();
        }

        return ResponseApi::statusSuccess()
            ->message('Data berhasil diperoleh.')
            ->data(auth('api')->user())
            ->json();
    }

    protected function expires_in_remember()
    {
        return Carbon::now()->addYears(2)->getTimestamp();
    }

    // token
    protected function respondWithToken($token)
    {
        $user = auth('api')->user();
        unset($user->roles);

        $userData = $user ? [
            ...$user->toArray(),
            'role' => $user->roles->first()->name ?? false,
        ] : [];

        return ResponseApi::statusSuccess()
            ->message('Login berhasil.')
            ->data([
                'user' => SecureCommunication::encrypt(json_encode($userData)),
                'access_token' => $token,
                'token_type' => 'bearer'
            ])->json();
    }
}