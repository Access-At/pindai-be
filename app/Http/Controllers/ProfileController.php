<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\ResponseApi;
use App\Http\Requests\ProfileRequest;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $profile = ProfileService::getProfile();

        return ResponseApi::statusSuccess()
            ->message('Get Profile Success')
            ->data($profile)
            ->json();
    }

    public function updateProfile(ProfileRequest $request)
    {
        $profile = ProfileService::updateProfile($request->validated());

        return ResponseApi::statusSuccess()
            ->message('Ubah data profile berhasil')
            ->data($profile)
            ->json();
    }

    public function updatePassword(Request $request)
    {
        $profile = ProfileService::changePassword($request);

        return ResponseApi::statusSuccess()
            ->data($profile)
            ->json();
    }
}
