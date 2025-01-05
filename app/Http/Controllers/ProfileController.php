<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\ResponseApi;
use Modules\Profile\DataTransferObjects\ProfileDto;
use Modules\Profile\Interfaces\ProfileServiceInterface;
use Modules\Profile\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function __construct(
        protected ProfileServiceInterface $service
    ) {}

    public function getProfile()
    {
        $profile = $this->service->getProfile();

        return ResponseApi::statusSuccess()
            ->message('Get Profile Success')
            ->data($profile)
            ->json();
    }

    public function updateProfile(ProfileRequest $request)
    {

        $this->service->updateProfile(
            ProfileDto::fromRequest($request)
        );

        return ResponseApi::statusSuccess()
            ->message('Berhasil ubah data profile')
            ->json();
    }

    // public function updatePassword(Request $request)
    // {
    //     $profile = ProfileService::changePassword($request);

    //     return ResponseApi::statusSuccess()
    //         ->data($profile)
    //         ->json();
    // }
}
