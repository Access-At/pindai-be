<?php

namespace App\Http\Controllers;

use App\Helper\EncryptData;
use App\Helper\ResponseApi;
use Modules\Profile\Requests\ProfileRequest;
use Modules\Profile\DataTransferObjects\ProfileDto;
use Modules\Profile\Interfaces\ProfileServiceInterface;

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
        $data = $this->service->updateProfile(
            ProfileDto::fromRequest($request)
        );

        $data = $this->service->getProfile();

        return ResponseApi::statusSuccess()
            ->message('Berhasil ubah data profile')
            ->data([
                'user' => EncryptData::encrypt(json_encode($data)),
            ])
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
