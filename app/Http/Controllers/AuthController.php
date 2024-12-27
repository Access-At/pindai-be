<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Helper\ResponseApi;
use App\Http\Requests\AuthRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\UserResource;
use App\Helper\EncryptData as HelperEncryptData;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $email = User::where('email', $request->email)->first();

        if (! $email) {
            return ResponseApi::statusQueryError()->message('Login gagal, Email tidak ditemukan.')->json();
        }

        if ($email->hasRole('kaprodi') && ! $email->kaprodi->is_active) {  // 0 = Nonaktif
            return ResponseApi::statusQueryError()->message('Login gagal, Akun anda telah dinonaktifkan. tolong hubungi DPPM')->json();
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
            ->data(new UserResource(auth('api')->user()))
            ->json();
    }

    protected function expires_in_remember()
    {
        return Carbon::now()->addYears(2)->getTimestamp();
    }

    protected function respondWithToken($token)
    {
        $user = auth('api')->user();

        $userData = [
            'name' => $user->name,
            'role' => $user->roles->first()->name ?? false,
            'email' => $user->email,
            'nidn' => $user->nidn,
        ];

        if ($user->roles->first()->name === 'dosen') {
            $userData = array_merge($userData, [
                'name_with_title' => $user->dosen->name_with_title ?? '',
                'phone_number' => $user->dosen->phone_number ?? '',
                'scholar_id' => $user->dosen->scholar_id ?? '',
                'scopus_id' => $user->dosen->scopus_id ?? '',
                'job_functional' => $user->dosen->job_functional ?? '',
                'affiliate_campus' => $user->dosen->affiliate_campus ?? '',
                'prodi' => $user->dosen->prodi->name ?? '',
            ]);
        }

        // $userData = $user ? [
        //     'name' => $user->name,
        //     'role' => $user->roles->first()->name ?? false,
        //     'user' => $user,
        //     'dosen' => $user->dosen ? $user->dosen : false,
        // ] : [];

        return ResponseApi::statusSuccess()
            ->message('Login berhasil.')
            ->data([
                'user' => HelperEncryptData::encrypt(json_encode($userData)),
                'token_type' => 'bearer',
                'access_token' => $token,
            ])->json();
    }
}
